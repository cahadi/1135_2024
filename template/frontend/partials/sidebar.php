<div class="sidebar">

    <h3 class="sidebar-title">Search</h3>
    <div class="sidebar-item search-form">
        <form action="">
            <input type="text">
            <button type="submit"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End sidebar search formn-->

    <h3 class="sidebar-title">Последние новости</h3>
    <div class="sidebar-item recent-posts">

        <?php
        echo sidebar();
        ?>

    </div><!-- End sidebar recent posts-->

    <h3 class="sidebar-title">Categories</h3>
    <div class="sidebar-item categories">
        <ul>
            <li><a href="#">General <span>(25)</span></a></li>
            <li><a href="#">Lifestyle <span>(12)</span></a></li>
            <li><a href="#">Travel <span>(5)</span></a></li>
            <li><a href="#">Design <span>(22)</span></a></li>
            <li><a href="#">Creative <span>(8)</span></a></li>
            <li><a href="#">Educaion <span>(14)</span></a></li>
        </ul>
    </div><!-- End sidebar categories-->

    <h3 class="sidebar-title">Tags</h3>
    <div class="sidebar-item tags">
        <ul>
            <li><a href="#">App</a></li>
            <li><a href="#">IT</a></li>
            <li><a href="#">Business</a></li>
            <li><a href="#">Mac</a></li>
            <li><a href="#">Design</a></li>
            <li><a href="#">Office</a></li>
            <li><a href="#">Creative</a></li>
            <li><a href="#">Studio</a></li>
            <li><a href="#">Smart</a></li>
            <li><a href="#">Tips</a></li>
            <li><a href="#">Marketing</a></li>
        </ul>
    </div><!-- End sidebar tags-->

</div><!-- End sidebar -->