<?php
    use App\Models\Blog;
    echo count(Blog::where('status','new')->get());
?>