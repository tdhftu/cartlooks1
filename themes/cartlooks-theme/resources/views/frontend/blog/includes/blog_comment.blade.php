{{-- Checking If comments is available or not --}}
@if (count($blog_comments) > 0)
    @php
        $comment_setting = commentFormSettings(); //All comment settings
        $comment_close = commentClose($blog->publish_at); //If a comment is close or not
    @endphp
    <h4 class="comments-title">Comments ({{ count($blog->allblogComment) }})</h4>
    {{-- Comment List --}}
    <ul class="comment-list">
        {{-- Loop through All Top Level Comments --}}
        @foreach ($blog_comments as $comment)
            @php
                // getiing the comment author image
                $author = null;
                if ($comment->user_type == 'admin') {
                    $author = Core\Models\User::where('id', $comment->user_id)->first();
                }
                if ($comment->user_type == 'customer') {
                    $author = Plugin\CartLooksCore\Models\Customers::where('id', $comment->user_id)->first();
                }
                
                $author_image = isset($author) ? $author->image : null;
                $author_name = isset($author) ? $author->name : null;
                
                // Finding the comment by Id
                $parent = Core\Models\TlBlogComment::where('id', $comment->id)->first();
                $count_child = count($parent->childs);
            @endphp
            <li class="comment">
                <!-- Single Comment -->
                <article class="single-comment media">
                    <!-- Comment Author Image -->
                    <div class="comment-author-image">
                        <img src="
                            @if (isset($author_image)) {{ getFilePath($author_image, true) }}
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
                                    {{ $comment->user_name }}
                                </h5>
                            @endif

                            <span class="commented-on">
                                <time datetime="2012-09-03T10:18:04+00:00">
                                    {{ date('d F Y \a\t H:i a', strtotime($comment->comment_date)) }}
                                </time>
                            </span>
                        </div>

                        <p>
                            {{ $comment->comment }}
                        </p>
                        @if (!($comment_setting['close_comments_for_old_blogs'] == '1' && $comment_close == true))
                            @if (isset($author_name))
                                <a href="javascript:void(0)" class="comment-reply-link reply-btn mr-10"
                                    v-on:click="replyComment({{ $comment->id }} , '{{ $author_name }}')"><i
                                        class="fa fa-mail-forward"></i> {{ translate('Reply') }}</a>
                            @else
                                <a href="javascript:void(0)" class="comment-reply-link reply-btn mr-10"
                                    v-on:click="replyComment({{ $comment->id }} , '{{ $comment->user_name }}')"><i
                                        class="fa fa-mail-forward"></i> {{ translate('Reply') }}</a>


                            @endif
                        @endif
                        @if ($count_child > 0)
                            {{-- see reply on collapse --}}
                            <a href="javascript:;void(0)"
                                v-on:click="moreCommentButton('#replyToggle{{ $comment->id }}','#icon-{{ $comment->id }}')">
                                <small class="font-weight-bold text-dark">{{ translate('See Replies') }}</small>
                                <i class="fa fa-angle-down font-weight-bold text-dark" id="icon-{{ $comment->id }}"
                                    aria-hidden="true"></i>
                            </a>
                        @endif
                    </div>
                    <!-- End Comment Content -->
                </article>
                <!-- End Single Comment -->
                {{-- if comment has reply including them --}}
                @if ($count_child > 0)
                    <div id="replyToggle{{ $comment->id }}" class="d-none">
                        @include('theme/cartlooks-theme::frontend.blog.includes.child_comment', [
                            'child_comment' => $parent->childs,
                            'label' => 1,
                        ])
                    </div>
                @endif
            </li>
        @endforeach
    </ul>
    {{-- Comment List End --}}
@endif
