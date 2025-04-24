<div class="divActions">
    @if ($hasComment ?? false)
        <a href="#" data-toggle="modal" data-target="#modalDetail{{ $id }}" data-id="{{ $id }}" class="btnAction">
            <i class="ti ti-message-2">
                @if($hasCommentPending)
                    <div id="notification-point{{ $id }}" class="notification-point"></div>
                @endif
            </i>
        </a>
    @endif
    @if ($hasUser ?? false)
        <a href="#" data-toggle="modal" data-target="#modalDetailClergy{{ $id }}" data-id="{{ $id }}" class="btnAction">
            <i class="ti ti-user"></i>
        </a>
    @endif
    @if ($hasDetail ?? false)
        @if($hasDetail === 'modal')
            <a id="moreInfo{{ $id }}" href="#" data-toggle="modal" data-target="#modalDetail{{ $id }}" class="btnAction">
                <i class="ti ti-info-square-rounded"></i>
            </a>
        @else
            <a id="moreInfo{{ $id }}" href="{{ route($item.".show", $id) }}" class="btnAction">
                <i class="ti ti-info-square-rounded"></i>
            </a>
        @endif
    @endif
    @if (Auth::user()->can('edit_'.$item) && ($hasEdit ?? false))
        @if($hasEdit === 'modal')
            <a id="editButton{{ $id }}" href="#" data-toggle="modal" data-target="#modalForm{{ $id }}" class="btnAction">
                <i class="ti ti-edit"></i>
            </a>
        @else
            <a id="editButton{{ $id }}" href="{{ route($item.".edit", $id) }}" class="btnAction">
                <i class="ti ti-edit"></i>
            </a>
        @endif
    @endif
    @if (Auth::user()->can('delete_'.$item) && ($hasDelete ?? false))
        <x-forms.delete-button
            route="{{ $item }}.delete"
            id="{{ $id }}"
            title="{{ __('message.title_delete_'.$item) }}"
        />
    @endif
</div>
