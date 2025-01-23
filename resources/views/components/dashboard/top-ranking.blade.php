<div>
    <div class="title-item">
        <h2>{{ $title }}</h2>
        @if($switch)
            <div class="switchs">
                <label type="value" class="valid{{ $id }} switch {{ $default == 'quantity' ? "" : "on" }}">{{ __('message.value') }}</label>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch{{ $id }}" {{ $default == 'quantity' ? "checked" : "" }}>
                    <label type="quantity" class="custom-control-label valid{{ $id }} switch  {{ $default == 'quantity' ? "on" : "" }}" for="customSwitch{{ $id }}">{{ __('message.quantity') }}</label>
                </div>
            </div>
        @endif
    </div>
    <div id="ranking{{ $id }}" class="top-ranking">
        <div class="legend">
            <span>{{ $legend }}</span>
            <span>{{ __('message.quantity') }}</span>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        var info{{ $id }} = JSON.parse('{!! json_encode($infos) !!}');
        remapRanking{{ $id }}('{{ $default }}');

        function remapRanking{{ $id }} (type) {
            let spanTraduction = type === 'quantity' ? '{{ __('message.quantity') }}' : '{{ __('message.value') }}';
            $('#ranking{{ $id }}').html('<div class="legend">' +
                    '<span>{{ $legend }}</span>' +
                    `<span>${spanTraduction}</span>` +
                '</div>');
            sortByKey(info{{ $id }}, type);
            info{{ $id }}.forEach(function (e, index) {

                var perc = e[type] / info{{ $id }}[0][type] * 100;
                var value = type === 'quantity'
                    ? e[type].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
                    : "R$ " + Math.round(e[type]).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                var html = '<div class="item-ranking">' +
                        '<div class="desc">' +
                            '<span>' + ++index + '</span>';

                html += e.image ? '<img src="' + e.image + '">' : '';

                html += index < 4 ? '<p class="bests">' + e.name + '</p>' : '<p>' + e.name + '</p>';

                html += '</div>' +
                        ' <div class="value-ranking">' +
                            '<span>' + value + '</span>' +
                            '<div class="progress progress-sm">' +
                                '<div class="progress-bar bg-primary" style="width: ' + perc + '%"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
                $('#ranking{{ $id }}').append(html);
            });
        }

        @if($switch)
            $('#customSwitch{{ $id }}').on('click', function () {
                $('.valid{{ $id }}').toggleClass('on');
                var type = $('.valid{{ $id }}.on').attr('type');
                remapRanking{{ $id }}(type);
            });
        @endif

        function sortByKey(array, key) {
            return array.sort(function (a, b) {
                var x = parseFloat(a[key]);
                var y = parseFloat(b[key]);
                return ((x > y) ? -1 : ((x < y) ? 1 : 0));
            });
        }
    });
</script>
