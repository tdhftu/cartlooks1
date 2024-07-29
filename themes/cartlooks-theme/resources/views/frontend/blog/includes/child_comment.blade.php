@php
    $label = $label + 1;
    $comment_setting = commentFormSettings(); //All comment settings
    $comment_close = commentClose($blog->publish_at); //If a comment is close or not
    
    // Cheking child comment thread level
    if ($comment_setting['thread_comments'] == 1) {
        $nested_level = $comment_setting['thread_comments_level'];
    } else {
        $nested_level = 6;
    }
@endphp

@foreach ($child_comment as $child)
    @php
        // getiing the comment author image
        $author = null;
        if ($child->user_type == 'admin') {
            $author = Core\Models\User::where('id', $child->user_id)->first();
        }
        if ($child->user_type == 'customer') {
            $author = Plugin\CartLooksCore\Models\Customers::where('id', $child->user_id)->first();
        }
        
        $author_image = isset($author) ? $author->image : null;
        $author_name = isset($author) ? $author->name : null;
        
        // counting all the reply this comment has
        $count_child = count($child->childs);
    @endphp
    <ul class="children">
        <li class="comment single-comment-wrapper row" id="comment-{{ $child->id }}">
            <!-- Single Comment -->
            <article class="single-comment media">
                <!-- Comment Author Image -->
                <div class="comment-author-image">
                    <img src="
                    @if (isset($author_image)) {{ asset(getFilePath($author_image, true)) }}
                    @else
                        @if ($comment_setting['show_avatars'] == 1)
                            {{ asset('/public/comment-author-image/' . $comment_setting['avatar_default'] . '.png') }}
                        @else
                            {{ getFilePath($author_image, true) }} @endif
                    @endif
                    "
                        alt="">
                </div>
                <!-- End Comment Author Image -->

                <!-- Comment Content -->
                <div class="comment-content media-body">
                    <div class="d-flex align-items-center">
                        @if (isset($author_name))
                            <h5 class="author_name">
                                {{ $author_name }}
                            </h5>
                        @else
                            <h5 class="author_name">
                                {{ $child->user_name }}
                            </h5>
                        @endif

                        <span class="commented-on">
                            <time datetime="2012-09-03T10:18:04+00:00">
                                {{ date('d F Y \a\t H:i a', strtotime($child->comment_date)) }}
                            </time>
                        </span>
                    </div>

                    <p>
                        {{ $child->comment }}
                    </p>
                    @if (!($comment_setting['close_comments_for_old_blogs'] == '1' && $comment_close == true))
                        @if (isset($author_name))
                            <a href="javascript:void(0)" class="comment-reply-link reply-btn mr-10 {{ $child->id }}"
                                v-on:click="replyComment({{ $child->id }} , '{{ $author_name }}')"><i
                                    class="fa fa-mail-forward"></i> {{ translate('Reply') }}</a>
                        @else
                            <a href="javascript:void(0)" class="comment-reply-link reply-btn mr-10"
                                v-on:click="replyComment({{ $child->id }} , '{{ $child->user_name }}')"><i
                                    class="fa fa-mail-forward"></i> {{ translate('Reply') }}</a>
                        @endif
                    @endif
                    @if ($count_child > 0)
                        {{-- see reply on collapse --}}
                        <a href="javascript:;void(0)"
                            v-on:click="moreCommentButton('#replyToggle{{ $child->id }}','#icon-{{ $child->id }}')">
                            <small class="font-weight-bold text-dark">{{ translate('See Replies') }}</small>
                            <i class="fa fa-angle-down font-weight-bold text-dark" id="icon-{{ $child->id }}"
                                aria-hidden="true"></i>
                        </a>
                    @endif
                </div>
                <!-- End Comment Content -->
            </article>
            <!-- End Single Comment -->

            @if ($count_child > 0)
                <div id="replyToggle{{ $child->id }}" class="d-none">
                    @include('theme/cartlooks-theme::frontend.blog.includes.child_comment', [
                        'child_comment' => $child->childs,
                        'label' => $label,
                    ])
                </div>
            @endif
        </li>
    </ul>
@endforeach
