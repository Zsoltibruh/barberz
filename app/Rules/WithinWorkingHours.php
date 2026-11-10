<?php

namespace App\Rules;

use App\Models\User;
use Carbon\CarbonImmutable;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Override;
use Throwable;

class WithinWorkingHours implements DataAwareRule, ValidationRule
{
    public function __construct(protected User $barber) {}

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
            $selected = CarbonImmutable::createFromFormat('Y-m-d H:i', "{$date} {$value}");
        } catch (Throwable) {
            return;
        }

        $hours = $this->barber->workingHours
            ->where('weekday', strtolower($selected->englishDayOfWeek))
            ->first();

        if (! $hours) {
            $fail(__('The barber does not work on this day'));

            return;
        }

        $start = $selected->setTimeFromTimeString($hours->start_time);
        $end = $selected->setTimeFromTimeString($hours->end_time);

        if ($selected->lt($start) || $selected->gte($end)) {
            $fail(__('Please select a date within the barber\'s working hours'));
        }
    }
}
