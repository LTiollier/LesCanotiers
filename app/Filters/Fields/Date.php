<?php

namespace App\Filters\Fields;

use App\Filters\Base\Field;
use App\Filters\Base\FieldContract;
use App\Filters\Services\Dates\Date as DateService;
use Illuminate\Database\Query\Builder;

class Date extends Field implements FieldContract
{
    const _STRATEGY_EQUALS = 'equals';
    const _STRATEGY_BETWEEN = 'between';
    const _STRATEGY_CURRENT_WEEK = 'current_week';
    const _STRATEGY_PAST_WEEK = 'past_week';
    const _STRATEGY_CURRENT_MONTH = 'current_month';
    const _STRATEGY_PAST_MONTH = 'past_month';

    /** @var array */
    const STRATEGIES = [
        self::_STRATEGY_EQUALS,
        self::_STRATEGY_BETWEEN,
        self::_STRATEGY_CURRENT_WEEK,
        self::_STRATEGY_PAST_WEEK,
        self::_STRATEGY_CURRENT_MONTH,
        self::_STRATEGY_PAST_MONTH,
    ];

    const _DEFAULT_FORMAT = 'Y-m-d H:i:s';

    /** @var DateService $dateService */
    protected $dateService;

    /**
     * @param Builder $query
     */
    public function __construct(Builder $query)
    {
        parent::__construct($query);

        $this->dateService = app(DateService::class);
    }

    /**
     * @param array $search
     * @param string $columnName
     * @return Builder
     */
    public function query(array $search, string $columnName): Builder
    {
        switch ($search['strategy']) {
            case self::_STRATEGY_BETWEEN:
                return $this->query->whereRaw("$columnName between ? and ?", [
                    $search['date'] . ' 00:00:00',
                    $search['second_date'] . ' 23:59:59',
                ]);

            case self::_STRATEGY_CURRENT_WEEK:
                return $this->query->whereRaw("$columnName >= ?", [
                    $this->dateService->getCurrentWeekStart()->format(static::_DEFAULT_FORMAT),
                ]);

            case self::_STRATEGY_PAST_WEEK:
                return $this->query->whereRaw("$columnName between ? and ?", [
                    $this->dateService->getPreviousWeekStart()->format(static::_DEFAULT_FORMAT),
                    $this->dateService->getPreviousWeekStop()->format(static::_DEFAULT_FORMAT),
                ]);

            case self::_STRATEGY_CURRENT_MONTH:
                return $this->query->whereRaw("$columnName >= ?", [
                    $this->dateService->getCurrentMonthStart()->format(static::_DEFAULT_FORMAT),
                ]);

            case self::_STRATEGY_PAST_MONTH:
                return $this->query->whereRaw("$columnName between ? and ?", [
                    $this->dateService->getPreviousMonthStart()->format(static::_DEFAULT_FORMAT),
                    $this->dateService->getPreviousMonthStop()->format(static::_DEFAULT_FORMAT),
                ]);
        }

        return $this->query->whereRaw("$columnName like ?", [$search['date'].'%']);
    }

    /**
     * @param string $fieldName
     * @return array<string, string>
     */
    public static function getRules(string $fieldName): array
    {
        $strategyList = implode(',', self::STRATEGIES);

        return [
            $fieldName => 'array',
            $fieldName . '.strategy' => 'required_with:' . $fieldName . '|string|in:' . $strategyList,
            $fieldName . '.date' => 'nullable|required_if:' . $fieldName . '.strategy,equals|date_format:Y-m-d',
            $fieldName . '.second_date' => 'nullable|required_if:' . $fieldName . '.strategy,between|date_format:Y-m-d',
        ];
    }
}
