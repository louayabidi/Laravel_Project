<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-header.header></x-header.header>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="{{ $post->title }}"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h4 class="mb-3">{{ $post->title }}</h4>
                    <p class="text-muted small mb-2">By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}</p>
                    <div class="mb-3">{!! nl2br(e($post->content)) !!}</div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#reportPostModal">
                            <i class="material-icons text-sm">flag</i> Report Post
                        </button>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="text-primary mb-3">Comments ({{ $post->comments->count() }})</h5>

                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
                        @csrf
                        <textarea name="content" class="form-control mb-2" rows="3" placeholder="Add a comment..." required></textarea>
                        <button type="submit" class="btn btn-primary btn-sm">Comment</button>
                    </form>

                    @php
                        $comments = $post->comments()->withCount('likes')->orderByDesc('likes_count')->get();
                    @endphp

                    @foreach($comments as $comment)
                    <div class="border p-3 rounded mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $comment->user->name }}</strong>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mt-2 mb-2">{{ $comment->content }}</p>

                        <div class="d-flex align-items-center">
                            <form action="{{ route('comments.like', $comment) }}" method="POST" class="me-2">
                                @csrf
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    ❤️ {{ $comment->likes->count() }}
                                </button>
                            </form>

                            <button class="btn btn-outline-danger btn-sm me-2" data-bs-toggle="modal" data-bs-target="#reportCommentModal-{{ $comment->id }}">
                                <i class="material-icons text-sm">flag</i> Report
                            </button>

                            @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="me-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                            @endif
                        </div>
                    </div>

                    <!-- Report Comment Modal -->
                    <div class="modal fade" id="reportCommentModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="reportCommentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h6 class="modal-title" id="reportCommentModalLabel">Report Comment</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('reports.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                        <div class="mb-3">
                                            <label class="form-label">Reason</label>
                                            <textarea name="reason" class="form-control" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Submit Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

    <!-- Report Post Modal -->
    <div class="modal fade" id="reportPostModal" tabindex="-1" aria-labelledby="reportPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h6 class="modal-title" id="reportPostModalLabel">Report Post</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('reports.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <textarea name="reason" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
