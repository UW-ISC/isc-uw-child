(function() {
    ISC = {
        search: {
            switchDefault: function() {
                // Swaps UW to Current Site as the default for searches
                $('#search-labels input[type="radio"]').each(function() {
                    $this = $(this);
                    if ($this.val() == 'site') {
                        $this.parent().addClass('checked');
                        $this.closest('#search-labels').prepend($this.parent());
                        $this.prop('checked', true);
                        $this.trigger('click');
                    } else if ($this.val() == 'uw') {
                        $this.parent().removeClass('checked');
                        $this.prop('checked', false);
                    }
                });
            },
            changeAction: function(){
                $('.uw-search').each(function(){
                    $this = $(this);
                    $this.attr('action', ISC_URL);
                });
            }
        },
        init: function() {
            this.search.switchDefault();
            this.search.changeAction();
        }
    };

    $(window).load(function() {
        ISC.init();
    });
})();
