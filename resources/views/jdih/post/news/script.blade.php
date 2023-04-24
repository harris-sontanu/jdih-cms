<script>

    $(function() {
        const lightbox = GLightbox({
            selector: '[data-bs-popup="lightbox"]',
            loop: true,
        });

        const triggerBookmark = $(".bookmark");
        triggerBookmark.click(function() {
            if (window.sidebar && window.sidebar.addPanel) { // Firefox <23
                window.sidebar.addPanel(document.title,window.location.href,'');
            } else if(window.external && ('AddFavorite' in window.external)) { // Internet Explorer
                window.external.AddFavorite(location.href,document.title);
            } else if(window.opera && window.print || window.sidebar && ! (window.sidebar instanceof Node)) { // Opera <15 and Firefox >23
                triggerBookmark.attr('rel', 'sidebar').attr('title', document.title).attr('href', window.location.href);
                return true;
            } else { // For the other browsers (mainly WebKit) we use a simple alert to inform users that they can add to bookmarks with ctrl+D/cmd+D
                alert('Anda bisa menandai halaman ini dengan menekan tombol ' + (navigator.userAgent.toLowerCase().indexOf('mac') != - 1 ? 'Command/Cmd' : 'CTRL') + ' + D pada papan ketik Anda');
            }
            return false;
        })
    });

</script>
