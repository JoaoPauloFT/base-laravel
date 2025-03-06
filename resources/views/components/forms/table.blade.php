@section('plugins.Datatables', true)
@section('plugins.Select2', true)

<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">

<div>
    <table id="myTable" class="display list">
        {{ $slot }}
    </table>
</div>

@section('js')
    <script>
        $(document).ready(function () {
            let columns = [];
            for (let i = 0; i < $('thead tr th').length; i++) {
                columns.push(i);
            }
            columns.pop();

            $.fn.dataTable.moment('{{ $moment }}');

            let table = new DataTable('#myTable', {
                responsive: true,
                @if($serverSide)
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route($routes.'.data') }}',
                    data: function (d) {
                        d.status = $('#filter-status').val();
                        $('#filterTable > select').each(function(index) {
                            d[$(this).attr('name')] = $(this).val();
                        });
                    }
                },
                @endif
                lengthMenu: [ [10, 25, 50, -1], ["{{ __('message.show') }} 10", "{{ __('message.show') }} 25", "{{ __('message.show') }} 50", "Todos"] ],
                language: {
                    search: "",
                    searchPlaceholder: "{{ __('message.search') }}",
                    info: "{{ __('message.info_table') }}",
                    paginate: {
                        next: "{{ __('message.next') }}",
                        previous: "{{ __('message.previous') }}"
                    },
                    emptyTable: "{{ __('message.emptyTable') }}",
                    infoEmpty: "{{ __('message.infoEmpty') }}",
                    infoFiltered: "{{ __('message.infoFiltered') }}",
                    zeroRecords: "{{ __('message.zeroRecords') }}",
                    lengthMenu: "_MENU_",
                    decimal: ",",
                    thousands: "."
                },
                @if($dropdownMultipleFilter || $dropdownFilter)
                dom: '<"header"fBr><"selects">"t<"bottom"<"lbottom"li>p>',
                @else
                dom: '<"header"fBr>"t<"bottom"<"lbottom"li>p>',
                @endif
                order: {!! $ordering !!},
                autoWidth: false,
                @if($columnsSide)
                columns: [
                        @foreach($columnsSide as $key => $c)
                    { data: '{{ $c }}', name: '{{ $c }}' },
                        @endforeach
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                @endif
                columnDefs: [
                        @foreach($customColumns as $key => $column)
                    {
                        target: {{ $key }},
                        {!! $column !!}
                    },
                        @endforeach
                    {
                        target: -1,
                        orderable: false,
                    },
                ],
                buttons: [
                        @if($hasExport)
                        @if($serverSide)
                    {
                        text: '<i class="ti ti-file-arrow-right"></i><span> {{ __('message.export') }} </span>',
                        action: function () {
                            window.location.href = '{{ route($routes.'.export') }}';
                        }
                    },
                        @else
                    {
                        extend: 'excel',
                        text: '<i class="ti ti-file-arrow-right"></i><span> {{ __('message.export') }} </span>',
                        exportOptions: {
                            columns: columns
                        }
                    },
                        @endif
                        @endif
                    {
                        extend: 'colvis',
                        text: '<i class="ti ti-settings"></i><span> {{ __('message.columns') }} </span>',
                        columnText: function ( dt, idx, title ) {
                            return '<span class="checkbox"><i class="fa-solid fa-check"></i></span>' + title;
                        }
                    }
                ],
                initComplete: function () {
                    @if(!$serverSide)
                    @if($dropdownMultipleFilter || $dropdownFilter)
                    let span = document.createElement('span');
                    span.setAttribute("class", 'filter-span');
                    span.innerText = '{{ __("message.filters") }}';
                    document.getElementsByClassName("selects")[0].appendChild(span);
                    @endif

                        @if($dropdownMultipleFilter)
                        this.api()
                        .columns({{ Illuminate\Support\Js::from($dropdownMultipleFilter) }})
                        .every(function () {
                            let column = this;

                            // Create select element
                            let select = document.createElement('select');
                            select.setAttribute("multiple", "multiple");
                            document.getElementsByClassName("selects")[0].appendChild(select);

                            $(select).addClass('selectFilter');
                            $(select).select2({
                                placeholder: $(this.header()).text(),
                            });

                            // Apply listener for user change in value
                            $(select).on('change', function () {
                                let values = $(this).select2("val");
                                let val = "";
                                if(values.length > 0) {
                                    val = "(";
                                    values.forEach(function (value) {
                                        val += DataTable.util.escapeRegex(value) + "|";
                                    });
                                    val = val.slice(0, -1) + ")";
                                }

                                column.search(val ? '^' + val + '$' : '', true, false).draw();

                                if ($('.btnLimpar').length == 0) {
                                    var btnLimpar = "<button type='button' class='btnLimpar'>{{ __('message.clear') }}</button>";
                                    $(".selects").append(btnLimpar);

                                    $('.btnLimpar').on('click', function () {
                                        $('.selectFilter').val('').trigger('change');
                                        $(this).remove();
                                    });
                                }
                            });


                            // Add list of options
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function (d) {
                                    select.add(new Option(d));
                                });
                        });
                    @endif

                        @if($dropdownFilter)
                        this.api()
                        .columns({{ Illuminate\Support\Js::from($dropdownFilter) }})
                        .every(function () {
                            let column = this;

                            // Create select element
                            let select = document.createElement('select');
                            select.add(new Option(''));
                            document.getElementsByClassName("selects")[0].appendChild(select);

                            $(select).addClass('selectFilter');
                            $(select).select2({
                                placeholder: $(this.header()).text(),
                            });

                            // Apply listener for user change in value
                            $(select).on('change', function () {
                                var val = DataTable.util.escapeRegex(select.value);

                                column
                                    .search(val ? '^' + val + '$' : '', true, false)
                                    .draw();

                                if(val && $('.btnLimpar').length == 0) {
                                    var btnLimpar = "<button type='button' class='btnLimpar'>{{ __('message.clear') }}</button>";
                                    $(".selects").append(btnLimpar);

                                    $('.btnLimpar').on('click', function () {
                                        $('.selectFilter').val('').trigger('change');
                                        $(this).remove();
                                    });
                                }
                            });


                            // Add list of options
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function (d, j) {
                                    select.add(new Option(d));
                                });
                        });
                    @endif
                    @else
                    let template = document.querySelector('#filterTemplate').content.cloneNode(true);
                    document.querySelector('.selects').appendChild(template);
                    $('.select-filter').select2();

                    $('.select-filter').on('change', function () {
                        table.ajax.reload();

                        if($('.btnLimpar').length == 0) {
                            var btnLimpar = "<button type='button' class='btnLimpar'>{{ __('message.clear') }}</button>";
                            $(".selects").append(btnLimpar);

                            $('.btnLimpar').on('click', function () {
                                $('.select-filter').val('').trigger('change');
                                $(this).remove();
                            });
                        }
                    });
                    @endif
                },
                @if($click)
                drawCallback: function() {
                    $(".clickable").click(function(e) {
                        let id = $(this).attr('data-id');

                        if($(e.target).is("td"))
                            location.href = '{{ $click }}/' + id;
                    });
                }
                @endif
            });

            const elements = document.querySelectorAll('.dt-button-down-arrow');

            elements.forEach(elements => {
                elements.remove();
            });
        });
    </script>
@stop
