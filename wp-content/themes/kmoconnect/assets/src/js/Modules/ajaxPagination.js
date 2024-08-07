export default function (selectors) {
    (function ($) {
        $(function () {

            if (!$(selectors).length) {
                return;
            }
            
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                const link = $(this).attr('href');
                getPage(link);
            });

            function getPage(url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $(selectors).html($(data).find(selectors).html());
                        const newUrl = url;
                        window.history.pushState({path: newUrl}, '', newUrl);
                    }
                });
            }

            $(window).on('popstate', function () {
                getPage(location.pathname);
            });
        })
    })(jQuery);
}