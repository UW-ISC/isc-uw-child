<script>
    // JS code for ISC-18279 New blockquote style ("banner")
    // this code has a center fix for the blockquote
    $(document).ready(function() {
        for (let x = 0; x < $("blockquote.banner p").length; x++) {
            let ele = $($("blockquote.banner p")[x]);
            if(ele.height() == 24) {
                ele.css('margin-top', '7px');
            } else {
                ele.css('margin-top', 'unset');
            }
        }
    });
</script>