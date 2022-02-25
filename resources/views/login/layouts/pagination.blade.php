@if ($paginator->hasPages())
    @php
        $page_number = $paginator->currentPage();
        if($page_number > 1){
            $page_minus = $page_number - 1;
        }else{
            $page_minus = 0;
        }
        $page_plus = $page_number + 1;

    @endphp
    <ul class="pagination">
        @if ($paginator->onFirstPage())
        @else
            <li>
                @if (!empty($_GET))
                    @if (isset($_GET['page']))
                        @php
                            $all_request = $_GET;
                            unset($all_request['page']);
                            $current_page_url = Request::path();
                            if(count($all_request) > 0){
                                $i = 0;
                                foreach ($all_request as $key => $value) {
                                    if($i == 0){
                                        $current_page_url = $current_page_url."?".$key."=".$value;       
                                    }else{
                                        $current_page_url = $current_page_url."&".$key."=".$value;
                                    }
                                    $i++;
                                }
                                $current_page_url = $current_page_url."&page=".$page_minus;
                            }else{
                                $current_page_url = $current_page_url."?page=".$page_minus;
                            }
                        @endphp
                        <a href="{{ route('base_url')."/".$current_page_url }}" rel="prev"><i class="icon-arrow-left2"></i></a>                    
                    @else
                        <a href="{{ request()->fullUrl() }}&page={{ $page_minus }}" rel="prev"><i class="icon-arrow-left2"></i></a>
                    @endif
                @else
                    <a href="{{ request()->fullUrl() }}?page={{ $page_minus }}" rel="prev"><i class="icon-arrow-left2"></i></a>
                @endif
                {{-- <a href="{{ $_SERVER["PHP_SELF"].$paginator->previousPageUrl() }}" rel="prev"><i class="icon-arrow-left2"></i></a> --}}
            </li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <a href="#" class="active">{{ $page }}</a>
                        </li>
                    @else
                        @if (!empty($_GET))
                            @if (isset($_GET['page']))
                                @php
                                    $all_request = $_GET;
                                    unset($all_request['page']);
                                    $current_page_url = Request::path();
                                    if(count($all_request) > 0){
                                        $i = 0;
                                        foreach ($all_request as $key => $value) {
                                            if($i == 0){
                                                $current_page_url = $current_page_url."?".$key."=".$value;       
                                            }else{
                                                $current_page_url = $current_page_url."&".$key."=".$value;
                                            }
                                            $i++;
                                        }
                                        $current_page_url = $current_page_url."&page=".$page;
                                    }else{
                                        $current_page_url = $current_page_url."?page=".$page;
                                    }
                                @endphp
                                <li>
                                    <a href="{{ route('base_url')."/".$current_page_url }}">{{ $page }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ request()->fullUrl() }}&page={{ $page }}">{{ $page }}</a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a href="{{ request()->fullUrl() }}?page={{ $page }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li>
                {{-- <a href="{{ $_SERVER["PHP_SELF"].$paginator->nextPageUrl() }}"><i class="icon-arrow-right2"></i></a> --}}
                @if (!empty($_GET))
                    @if (isset($_GET['page']))
                        @php
                            $all_request = $_GET;
                            unset($all_request['page']);
                            $current_page_url = Request::path();
                            if(count($all_request) > 0){
                                $i = 0;
                                foreach ($all_request as $key => $value) {
                                    if($i == 0){
                                        $current_page_url = $current_page_url."?".$key."=".$value;       
                                    }else{
                                        $current_page_url = $current_page_url."&".$key."=".$value;
                                    }
                                    $i++;
                                }
                                $current_page_url = $current_page_url."&page=".$page_plus;
                            }else{
                                $current_page_url = $current_page_url."?page=".$page_plus;
                            }
                        @endphp
                        <a href="{{ route('base_url')."/".$current_page_url }}"><i class="icon-arrow-right2"></i></a> 
                    
                    @else
                        <a href="{{ request()->fullUrl() }}&page={{ $page_plus }}"><i class="icon-arrow-right2"></i></a>
                    @endif
                @else
                    <a href="{{ request()->fullUrl() }}?page={{ $page_plus }}"><i class="icon-arrow-right2"></i></a>
                @endif
            </li>
        @endif
    </ul>
@endif 