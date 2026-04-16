<?php

namespace App\DataTables;

use App\Enums\OrganizationStatusEnum;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use App\Models\OrganizationRating;
use App\Traits\OrganizationOverallRating;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OrganizationRatingDataTable extends DataTable
{
    use OrganizationOverallRating;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('userId', function ($row) {
                $formattedName = $row?->user ?
                ucwords(strtolower($row->user->firstName . ' ' . $row->user->lastName)) :
                'Anonymous';
            return mb_strimwidth($formattedName, 0, 20, "...");

            })
            ->editColumn('status', function ($row) {
                return '<span class="badge badge-pill status-style">' . 'Pending Approval' . '</span>';
            })
            ->editColumn('organizationId', function ($row) {
                return $row->organization?->name ?? '--';
            })
            ->editColumn('experience', function ($row) {
                $experience = $row->experience;
                $truncatedExperience = strlen($experience) > 50 ? substr($experience, 0, 50) . '...' : $experience;
                return $truncatedExperience;
            })
            ->editColumn('date', function ($row) {
                return $row->createdAt->timestamp;
            })
            ->editColumn('Overall', function ($row) {
                return $this->getOverAllOrganizationRating($row->id) ?? '--';
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn float-left" style="padding: 0% !important" onclick="viewOrganizationRating(' . $row->id . ')">
                           <svg width="57" height="32" viewBox="0 0 57 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="57" height="32" rx="5" fill="#34A853"/>
                            <path d="M15.2219 20.5L12.0219 10.036H13.9899L15.3979 15.3C15.5046 15.6947 15.6059 16.0787 15.7019 16.452C15.7979 16.8147 15.8939 17.1827 15.9899 17.556C16.0966 17.9187 16.2086 18.2973 16.3259 18.692H16.3899C16.4966 18.2973 16.5979 17.9187 16.6939 17.556C16.7899 17.1827 16.8859 16.8147 16.9819 16.452C17.0886 16.0787 17.1953 15.6947 17.3019 15.3L18.8219 10.036H20.7259L17.4139 20.5H15.2219ZM21.8321 20.5V12.644H23.6721V20.5H21.8321ZM22.7441 11.268C22.4241 11.268 22.1574 11.172 21.9441 10.98C21.7414 10.788 21.6401 10.532 21.6401 10.212C21.6401 9.892 21.7414 9.64133 21.9441 9.46C22.1574 9.268 22.4241 9.172 22.7441 9.172C23.0747 9.172 23.3414 9.268 23.5441 9.46C23.7467 9.64133 23.8481 9.892 23.8481 10.212C23.8481 10.532 23.7467 10.788 23.5441 10.98C23.3414 11.172 23.0747 11.268 22.7441 11.268ZM29.3956 20.692C28.6596 20.692 27.9929 20.532 27.3956 20.212C26.8089 19.8813 26.3449 19.412 26.0036 18.804C25.6622 18.1853 25.4916 17.4387 25.4916 16.564C25.4916 15.7107 25.6676 14.98 26.0196 14.372C26.3716 13.7533 26.8249 13.2787 27.3796 12.948C27.9342 12.6173 28.5209 12.452 29.1396 12.452C29.8542 12.452 30.4516 12.612 30.9316 12.932C31.4116 13.252 31.7689 13.6947 32.0036 14.26C32.2489 14.8147 32.3716 15.4547 32.3716 16.18C32.3716 16.3507 32.3609 16.516 32.3396 16.676C32.3289 16.836 32.3076 16.9907 32.2756 17.14H26.8676V15.732H30.7396C30.7396 15.1667 30.6116 14.724 30.3556 14.404C30.0996 14.0733 29.7049 13.908 29.1716 13.908C28.8729 13.908 28.5796 13.988 28.2916 14.148C28.0142 14.308 27.7796 14.58 27.5876 14.964C27.4062 15.348 27.3156 15.8813 27.3156 16.564C27.3156 17.1827 27.4222 17.6893 27.6356 18.084C27.8489 18.468 28.1316 18.756 28.4836 18.948C28.8356 19.1293 29.2142 19.22 29.6196 19.22C29.9609 19.22 30.2809 19.172 30.5796 19.076C30.8889 18.98 31.1769 18.8467 31.4436 18.676L32.0836 19.86C31.7209 20.116 31.3049 20.3187 30.8356 20.468C30.3769 20.6173 29.8969 20.692 29.3956 20.692ZM35.4093 20.5L33.3293 12.644H35.2173L36.1453 16.724C36.2306 17.076 36.3053 17.4387 36.3693 17.812C36.4333 18.1747 36.492 18.5907 36.5453 19.06H36.6093C36.684 18.5907 36.7533 18.1747 36.8173 17.812C36.892 17.4387 36.9666 17.076 37.0413 16.724L38.0013 12.644H39.9213L40.9133 16.724C40.9986 17.076 41.0786 17.4387 41.1533 17.812C41.228 18.1747 41.3026 18.5907 41.3773 19.06H41.4413C41.516 18.5907 41.58 18.1747 41.6333 17.812C41.6973 17.4387 41.7666 17.076 41.8413 16.724L42.7693 12.644H44.5293L42.5293 20.5H40.1773L39.3773 16.852C39.3026 16.5 39.228 16.148 39.1533 15.796C39.0893 15.4333 39.0253 14.996 38.9613 14.484H38.8973C38.8333 14.996 38.7693 15.4333 38.7053 15.796C38.6413 16.148 38.5666 16.5 38.4813 16.852L37.6813 20.5H35.4093Z" fill="white"/>
                            </svg>

                        </button>';
            })->rawColumns(['action', 'userId', 'status', 'experience', 'date', 'Overall'])
            ->filterColumn('userId', function ($query, $keyword) {
                $query->whereHas('user', function ($query) use ($keyword) {
                    $query->where('firstName', 'like', "%{$keyword}%")
                        ->orWhere('lastName', 'like', "%{$keyword}%");
                });
            })->filterColumn('organizationId', function ($query, $keyword) {
                $query->whereHas('organization', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                });
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OrganizationRating $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OrganizationRating $model)
    {
        return $model->where('status', OrganizationStatusEnum::NEED_APPROVAL)->orderBy('createdAt', 'desc')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {

        return $this->builder()
            ->setTableId('organizationrating-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('<"top"f>rt<"bottom"ip><"clear">')
            ->parameters([
                'ordering' => false,
                'processing' => true,
                'language' => [
                    'search' => '',
                    'paginate' => [
                        'previous' => '<span class="paginate-btn prev"><<</span>',
                        'next' => '<span class="paginate-btn next">>></span>'
                    ],
                    'searchPlaceholder' => "Search here..",
                    "search" => "<span class='text-secondary'><svg width='19' height='18' viewBox='0 0 19 18' fill='none' xmlns='http://www.w3.org/2000/svg'>
                        <path d='M17.0728 18L10.7728 11.7C10.2728 12.1 9.69778 12.4167 9.04778 12.65C8.39778 12.8833 7.70611 13 6.97278 13C5.15611 13 3.61861 12.3708 2.36028 11.1125C1.10195 9.85417 0.472778 8.31667 0.472778 6.5C0.472778 4.68333 1.10195 3.14583 2.36028 1.8875C3.61861 0.629167 5.15611 0 6.97278 0C8.78944 0 10.3269 0.629167 11.5853 1.8875C12.8436 3.14583 13.4728 4.68333 13.4728 6.5C13.4728 7.23333 13.3561 7.925 13.1228 8.575C12.8894 9.225 12.5728 9.8 12.1728 10.3L18.4728 16.6L17.0728 18ZM6.97278 11C8.22278 11 9.28528 10.5625 10.1603 9.6875C11.0353 8.8125 11.4728 7.75 11.4728 6.5C11.4728 5.25 11.0353 4.1875 10.1603 3.3125C9.28528 2.4375 8.22278 2 6.97278 2C5.72278 2 4.66028 2.4375 3.78528 3.3125C2.91028 4.1875 2.47278 5.25 2.47278 6.5C2.47278 7.75 2.91028 8.8125 3.78528 9.6875C4.66028 10.5625 5.72278 11 6.97278 11Z' fill='#888888'/>
                        </svg>
                    </span>",
                ],
                'infoCallback' => 'function(settings, start, end, max, total, pre ) {
                                if (total == 0) {
                                return `<span class="mb-1 d-flex"> <span class="ml-2 table-heading-sideContent"> Showing 0 entries </span> </span> `;
                                  }if (total == 1) {
                                return `<span class="mb-1 d-flex"><span class="ml-2 table-heading-sideContent"> Showing 1 entry </span> </span> `;
                                  } else {
                                  return `<span class="mb-1 d-flex"> <span class="ml-2 table-heading-sideContent"> Showing `+start+` to `+end+` entries </span> </span> `;
                                 }
                }',
                'initComplete' => 'function(settings, json) {
                    $(".dataTables_filter input")
                        .addClass("search-border");
                }',
                'drawCallback' => 'function(settings) {
                    var dateTime = this.api();

                    dateTime.rows().every(function() {

                    var data = this.data();
                    var dateValue = data.date;
                    var localDate = setDateTimeLocal(dateValue, "date");
                    dateTime.cell(this, 4).data(localDate);
                   })
            }',
            ])
            ->orderBy(1)
            ->serverSide(true)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('DT_RowIndex')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->title('#')
                ->addClass('text-center'),
            Column::make('userId')->title('Given By')->style('max-width: 120px;')->orderable(false),
            Column::make('status')->title('Status')->orderable(false)->searchable(false),
            Column::make('organizationId')->title('Organization')->orderable(false),
            Column::make('date')->title('Date')->style('min-width: 100px;')->orderable(false)->searchable(false),
            Column::make('Overall')->title('Overall')->orderable(false)->searchable(false),
            Column::make('experience')->title('Review')->style('min-width: 250px;')->orderable(false)->searchable(false),
            Column::make('action')->title('Actions')->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'OrganizationRating_' . date('YmdHis');
    }
}
