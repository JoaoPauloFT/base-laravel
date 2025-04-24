<link rel="stylesheet" href="{{ asset('css/tabs.css') }}">
<div class="tab-component {{ $fullHeight ? 'full-height' : '' }} {{ $fullWidth ? 'full-width' : '' }}">
    <div class='d-flex align-items-center justify-content-start app-tabs {{ $noBorder ? "no-border-shadow" : '' }}'>
        @foreach ($tabs as $index => $tab)
            <div class='tab tabC{{ $idItem }} {{ $index == $active ? "active-tab" : "" }}' data-tab="tab-{{ $index }}{{ $idItem }}">
                <p>{{ __($tab) }}</p>
            </div>
        @endforeach
    </div>
    {{ $slot }}
</div>

<script>
window.addEventListener("load", function () {
    const tabs = document.querySelectorAll(".tabC{{ $idItem }}");
    const contents = document.querySelectorAll(".tab-content{{ $idItem }}");

    tabs.forEach(tab => {
        tab.addEventListener("click", function () {
            tabs.forEach(t => t.classList.remove("active-tab"));
            contents.forEach(c => c.classList.add("hidden"));

            tab.classList.add("active-tab");
            document.getElementById(tab.getAttribute("data-tab")).classList.remove("hidden");
        });
    });
});
</script>
