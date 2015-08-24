<li class="dropdown">
    <!-- This works well for static text, like a username -->
    <a class="dropdown-toggle" data-toggle="dropdown" role="button"
       aria-expanded="false">{{$currentUser->first_name}} {{$currentUser->last_name}}
        <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li class="item"><a href=""></a></li>
        @if($currentUser->menu_items != null)
            @foreach($currentUser->menu_items as $index=>$item)
                @if(isset($item->isHeader) && $item->isHeader)
                    <li class="dropdown-header">{{$item->text}}</li>
                @else
                    <li class="item"><a href="{!! $item->url !!}">{{$item->text}}</a></li>
                @endif
            @endforeach
        @endif
    </ul>

</li>
<!-- Add any additional bootstrap header items.  This is a drop-down from an icon -->