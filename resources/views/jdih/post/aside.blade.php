<aside class="sidebar sidebar-component sidebar-expand-lg align-self-start bg-transparent shadow-none me-lg-3">

    <div class="sidebar-content">

        @isset($view)
            @include($view)
        @endisset

        @include('jdih.post.aside-content')

    </div>

</aside>
