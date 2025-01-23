<link rel="stylesheet" href="{{ asset('css/tabs.css') }}">

<nav class="tab-show mb-3">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @for($i = 0; $i < count($tabs); $i++)
            <button id="tab-{{ $tabs[$i]['code'] }}" class="nav-link" data-tab="{{ $tabs[$i]['code'] }}">{{ $tabs[$i]['name'] }}</button>
        @endfor
    </div>
</nav>

<div class="body">
    <div id="tab-content-screen" class="tab-content">
    </div>
</div>

<script>
    window.addEventListener('load', function () {
        $('#tab-content-screen').load("{{ URL::to("").'/'.$defaultUrl.'/'.$idParent }}");
        $('#tab-{{ $defaultUrl }}').addClass('active');

        // Alterna entre as abas e carrega o conteúdo correspondente
        $('.nav-link').click(function(e) {
            e.preventDefault();

            // Remove classe ativa de todas as abas e adiciona à aba clicada
            $('.nav-link').removeClass('active');
            $(this).addClass('active');

            var tab = $(this).data('tab');
            $('#tab-content-screen').load('{{ URL::to("") }}/' + tab + "/{{ $idParent }}");
        });
    });
</script>
