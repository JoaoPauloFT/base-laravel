@section('plugins.Datatables', true)
@section('plugins.Select2', true)

<link rel="stylesheet" href="{{ asset('css/datatables.css') }}">

<div>
    @if($serverSide)
        <div class="loading-table">
            <x-common.loading-screen />
        </div>
    @endif
    <table id="myTable" class="display list">
        {{ $slot }}
    </table>
</div>

<script>
    window.addEventListener('load', function () {
        let columns = [];
        for (let i = 0; i < $('thead tr th').length; i++) {
            columns.push(i);
        }
        columns.pop();
        $.fn.dataTable.moment('{{ $moment }}');

        let table = new DataTable('#myTable', {
            responsive: true,
            @if($serverSide)
                processing: false,
                serverSide: true,
                ajax: {
                    url: '{{ route($routes.'.data') }}',
                    data: function (d) {
                        d.status = $('#filter-status').val();
                        $('#filterTable > select, input').each(function(index) {
                            if($(this).is(':checkbox')){
                                $(this).is(':checked') ? d[$(this).attr('name')] = $(this).val() : ''
                            } else {
                                d[$(this).attr('name')] = $(this).val();
                            }
                        });
                    },
                    beforeSend: function () {
                        $('.loading-screen').removeClass('hidden');
                        $('#bulkDeleteButton').attr('style','display: none !important');
                    },
                    complete: function () {
                        $('.loading-screen').addClass('hidden');
                    },
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
            @if($columnsSide)
                columns: [
                    @foreach($columnsSide as $key => $c)
                        { data: '{{ $key }}', name: '{{ $key }}', className: '{{ $c }}' },
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
                {
                    "targets"  : 'no-sort',
                    "orderable": false,
                    "order": []
                }
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
                },
                @if($hasBulkDelete)
                {
                    text: '<i class="ti ti-trash"></i><span> {{ __('message.delete_selected_donations') }} </span>',
                    attr: {
                        class: 'danger-button hidden',
                        id: 'bulkDeleteButton'
                    },
                    action: function(){
                        bulkDelete();
                    }
                },
                @endif
                @if($hasButtonContributions)
                    {
                        text: '<i class="ti ti-analyze"></i><span> {{ __('message.move_to_prepared') }} </span>',
                        attr: {
                            class: 'primary-button hidden',
                            id: 'moveToPreparedButton'
                        },
                        action: function(){
                            movetoPrepared();
                        }
                    },
                    {
                        text: '<i class="ti ti-trash"></i><span> {{ __('message.delete_selected_contributions') }} </span>',
                        attr: {
                            class: 'danger-button hidden',
                            id: 'contributionsDeleteButton'
                        },
                        action: function(){
                            deleteEnvelopes();
                        }
                    }
                @endif
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
                    $('.select-filter').select2().on('change', function () {
                        changeFilters();
                    }).on('select2:unselecting', function(e) {
                        e.preventDefault();
                    });
                    
                    let debounceTimer;

                    $('#filterTable').find('input:not(:checkbox)').on('input change', function() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => {
                            changeFilters();
                        }, 1000);
                    });

                    $('#filterTable').find('input:checkbox').on('change', function(){
                        changeFilters();
                    });
                    
                    $('.select-filter[multiple]').select2().on('change', function () {
                        let val = $(this).val();
                        if(val.length === 0) {
                            $('.btnLimpar').remove();
                        }
                    });

                    $('.input-date-filter').daterangepicker({
                        showDropdowns: true,
                        autoUpdateInput: false,
                        autoApply: true,
                        "locale": {
                            "format": "MM/DD/YYYY",
                            "separator": " - ",
                            "applyLabel": "{{ __('message.apply') }}",
                            "cancelLabel": "{{ __('message.clear') }}",
                            "fromLabel": "From",
                            "toLabel": "To",
                            "customRangeLabel": "Custom",
                            "weekLabel": "W",
                            "daysOfWeek": [
                                "{{ __('message.dom') }}",
                                "{{ __('message.seg') }}",
                                "{{ __('message.ter') }}",
                                "{{ __('message.qua') }}",
                                "{{ __('message.qui') }}",
                                "{{ __('message.sex') }}",
                                "{{ __('message.sab') }}",
                            ],
                            "monthNames": [
                                "{{ __('message.January') }}",
                                "{{ __('message.February') }}",
                                "{{ __('message.March') }}",
                                "{{ __('message.April') }}",
                                "{{ __('message.May') }}",
                                "{{ __('message.June') }}",
                                "{{ __('message.July') }}",
                                "{{ __('message.August') }}",
                                "{{ __('message.September') }}",
                                "{{ __('message.October') }}",
                                "{{ __('message.November') }}",
                                "{{ __('message.December') }}"
                            ],
                        },
                    }).on('apply.daterangepicker', function(ev, picker) {
                        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                        changeFilters();
                    });

                    function changeFilters() {
                        table.ajax.reload();

                        if($('.btnLimpar').length === 0) {
                            var btnLimpar = "<button type='button' class='btnLimpar'>{{ __('message.clear') }}</button>";
                            $(".selects").append(btnLimpar);
                            verifyAdvancedFilter();

                            $('.btnLimpar').on('click', function () {
                                $('.input-date-filter').val('');
                                $('.select-filter').val('').trigger('change.select2');
                                $('#filterTable').find('input:not(:checkbox)').val('');
                                $('#filterTable').find('input:checkbox').prop('checked', false);
                                $(".multiple").val([]).change();
                                changeFilters();
                                $('.btnLimpar').remove();
                                verifyAdvancedFilter();
                            });
                        }
                    }

                    $('.advanced-filters-button').on('click', function(){
                        $('.filters-showing').toggleClass('height-filters');
                        if($(this).find('.ti').hasClass('ti-chevrons-down')){
                            $(this).find('.ti').removeClass('ti-chevrons-down');
                            $(this).find('.ti').addClass('ti-chevrons-up');
                        } else {
                            $(this).find('.ti').addClass('ti-chevrons-down');
                            $(this).find('.ti').removeClass('ti-chevrons-up');
                        }
                    });

                    $('.field-money').mask("#,##0.00", {
                        reverse: true
                    });

                    $('.field-decimal-money').mask("999999.00",{
                        reverse:true
                    })
                    
                    verifyAdvancedFilter();

                    $(window).on("resize", function() {
                        verifyAdvancedFilter();
                    });

                    function verifyAdvancedFilter(){
                        $('.filters-showing').removeClass('height-filters');
                        let form_height = $('.filters-showing').height();
                        if(form_height > 39){
                            $('.advanced-filters-button').attr('style','');
                        } else {
                            $('.advanced-filters-button').attr('style','display: none !important;');
                        }
                        $('.filters-showing').addClass('height-filters');
                        $('.advanced-filters-button').find('.ti').removeClass('ti-chevrons-up');
                        $('.advanced-filters-button').find('.ti').addClass('ti-chevrons-down');
                    }
        
                @endif
            },
            @if($click)
                drawCallback: function() {
                    $(".clickable").click(function(e) {
                        let id = $(this).attr('data-id');

                        if($(e.target).is("td"))
                            location.href = '{{ $click }}/' + id;
                    });

                    $('.item-checkbox').each(function(idx, element){
                        if(checkboxes_selected.indexOf($(element).data('id')) > -1){
                            $(element).prop('checked', true);
                        }
                    });

                    if($('.item-checkbox:checked').length == $('.item-checkbox').length && $('.item-checkbox').length){
                        $('.check-all').prop('checked', true);
                    } else {
                        $('.check-all').prop('checked', false);
                    }

                    let found = "";
                    $('.check-all').on('click', function(){
                        if($(this).is(':checked')){
                            $('.item-checkbox').prop('checked',true).trigger('change');
                            updateSelectedItems();
                        } else {
                            $('.item-checkbox').prop('checked',false).trigger('change');
                        }
                    });

                    $('#bulkDeleteButton').attr('style','display: none !important');
                    $('#contributionsDeleteButton').attr('style','display: none !important');
                    $('#moveToPreparedButton').attr('style','display: none !important');
                    
                    showButtons(checkboxes_selected.length);

                    $('.item-checkbox').on('change', function(){

                        if($(this).is(':checked')){
                            var index = checkboxes_selected.indexOf($(this).data('id'));
                            if (index == -1) {
                                checkboxes_selected.push($(this).data('id'));
                            }
                        } else {
                            var index = checkboxes_selected.indexOf($(this).data('id'));
                            if (index > -1) {
                                checkboxes_selected.splice(index, 1);
                            }
                        }

                        updateSelectedItems();
                        showButtons(checkboxes_selected.length);

                        if($('.item-checkbox:checked').length == $('.item-checkbox').length){
                            $('.check-all').prop('checked', true);
                        } else {
                            $('.check-all').prop('checked', false);
                        }
                    });

                    let selectedItems = [];
                    function updateSelectedItems() {//Armazena status e id para Contributions e verifica o status para habilitar botão "Move to prepared"
                        selectedItems = [];
                        $(".item-checkbox:checked").each(function() {
                            let id = $(this).attr("data-id");
                            let status = $(this).closest("tr").find("td .status-envelope span").attr("class");

                            selectedItems.push({ id: id, status: status });
                            if(selectedItems.some(item => item.status === "preparing")) {
                                found = true;
                            }else{
                                found = false;
                            }
                        });

                        if(found){
                            $('#moveToPreparedButton').attr('style','');
                        }else{
                            $('#moveToPreparedButton').attr('style','display: none !important');
                        }
                    }

                    function showButtons(checkboxes_selected_length) {
                        if(checkboxes_selected_length){
                            $('#bulkDeleteButton').attr('style','');
                            $('#contributionsDeleteButton').attr('style','');
                        } else {
                            $('#bulkDeleteButton').attr('style','display: none !important');
                            $('#contributionsDeleteButton').attr('style','display: none !important');
                            $('#moveToPreparedButton').attr('style','display: none !important');
                        }
                    }
                }
            @endif
        });

        const elements = document.querySelectorAll('.dt-button-down-arrow');

        elements.forEach(elements => {
            elements.remove();
        });
    });

    let checkboxes_selected = [];
</script>
