<form id="update-question-form" action="{{ route('admin.questionner.question.update', $question->id) }}" method="post" novalidate>
    @method('PUT')
    @csrf
    <input type="hidden" id="question-type" name="type" value="identity">
    <div class="modal-header border-bottom-0 pb-0">
        <h5 class="modal-title">Ubah Pertanyaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label for="title" class="form-label">Pertanyaan:</label>
            <textarea name="title" id="title" rows="4" class="form-control">{{ $question->title }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilihan Jawaban:</label>
            <div class="answer-option-list">
                @php $i = 1; @endphp
                @foreach ($question->answers as $answer)                    
                    <div class="row mb-3">
                        <label class="col-lg-1 col-form-label text-lg-end">{{ $i }}.</label>
                        <div class="col-lg-11">
                            <div class="input-group">
                                <input id="answers" type="text" name="answers[{{ $answer->id }}]" class="form-control" value="{{ $answer->name }}">
                                <button type="button" class="btn btn-light delete-answer" @if ($i === 1) disabled @endif data-id="{{ $answer->id }}"><i class="ph-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal-footer border-top-0 pt-0">
        <button type="button" class="btn btn-link add-answer-option" data-sequence="{{ $i - 1 }}">Tambah Pilihan Jawaban</button>
        <button type="submit" class="btn btn-indigo">Ubah</button>
    </div>
</form>