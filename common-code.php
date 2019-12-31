<script>
    // Code for when priting the pictures 
    // creates and adds the new class to the image tag which has the actual width and height 
    $(document).ready(function() {
        $("p a img").each(function(i) {
            $("<style>")
                .prop("type", "text/css")
                .html("@media print {\
                .print-size-" + i + " {\
                    width: " + this.naturalWidth + "px;\
                    height: " + this.naturalHeight + "px;\
                }}")
                .appendTo("head");
            $(this).addClass("print-size-" + i);
        });
        
    });
</script>