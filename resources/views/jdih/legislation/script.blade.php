<script>
    $(function() {

        $('.select-search').select2();

        $('.select').select2({
            minimumResultsForSearch: Infinity
        });

        $(".filter-form").submit(function() {
            $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
            return true;
        });

        var monographSlider = tns({
            "container": "#monograph-slider",
            "mode": "gallery",
            "items": 1,
            "controls": false,
            "autoplay": true,
            "autoplayTimeout": 3500,
            "autoplayHoverPause": true,
            "mouseDrag": true,
            "swipeAngle": false,
            "speed": 400,
            "nav": false,
            "autoplayButtonOutput": false
        });

    });
</script>