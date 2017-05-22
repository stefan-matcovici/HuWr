{{--{{dd($paginator->url(1))}}--}}

<nav class = "mt-2" aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage()-1)}}">Previous</a></li>
        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage())}}">{{$paginator->currentPage()}}</a></li>
        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage()+1)}}">{{$paginator->currentPage() + 1}}</a></li>
        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage()+2)}}">{{$paginator->currentPage() + 2}}</a></li>
        <li class="page-item disabled"><a class="page-link">...</a></li>
        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->lastPage()-1)}}">{{$paginator->lastPage()-1}}</a>
        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage())}}">{{$paginator->lastPage()}}</a></li>
        <li class="page-item"><a class="page-link" href="{{$paginator->url($paginator->currentPage()+1)}}">Next</a></li>
    </ul>
</nav>