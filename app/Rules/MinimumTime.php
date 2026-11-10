<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Override;
use Throwable;

class MinimumTime implements DataAwareRule, ValidationRule
{
    /**
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * @param  array<string, mixed>  $data
     */
    #[Override]
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = $this->data['date'] ?? null;

        if (! $date) {
            return;
        }

        try {
            $selected = Carbon::createFromFormat('Y-m-d H:i', "{$date} {$value}");
        } catch (Throwable) {
            return;
        }

        if ($selected->lt(now()->addHours(config('booking.minimum_notice_hours')))) {
            $fail(__('Please select a time at least :hours before :now', [
                'hours' => config('booking.minimum_notice_hours'),
                'now' => now()->format('H:i'),
            ]));
        }
    }

    // TODO: Időpont ütközések fixelése:
    // Ezeken az időpontokon belül NE tudjanak foglalni
    // 9:00 - 10:00 (60p)
    // 14:30 - 16:00 (90p)

    // Minimum kiválasztható idő: 10:00 - 14:00
    // Maximum -,,-: 16:00 - 18:00
    // Tehát pl. 8:00 vagy 16:30 NE legyen foglalható időpont
    // Illetve úgy se tudjunk időpontot foglalni, hogy a szolgáltatás ideje belenyúlik
    // Pl.: 8:00-ra fogalalunk időpontot, ami tartana 90 percig
    // Ezt nem engedhetjük, mert belelóg a 9:00-s időpontba (9:30-ig tartana)

    // TODO: Időpont foglalás vegye figyelembe a fodrászat nyitvatartását is
    // Ha a fodrászat 6-kor nyit, 6 előttre ne lehessen időpontot foglalni
    // és ha 18:00-ig van nyitva, 18:00 utánra se lehessen
    // tehát a minimum és maximum foglalható időpontok: 6:00 - 18:00
    // (a zárási időponthoz esetleg egy tűrési határ a szolgáltatásora,
    // pl. ha egy szolgáltatás több mint fél óra már ne lehessen foglalni)
}
