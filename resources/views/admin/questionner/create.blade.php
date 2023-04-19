<!-- Modal -->
<div class="modal fade" id="create-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="store-question-form" action="{{ route('admin.questionner.question.store') }}" method="post" novalidate>
                @csrf
                <input type="hidden" id="question-type" name="type" value="identity">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Pertanyaan:</label>
                        <input id="title" type="text" class="form-control" name="title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilihan Jawaban:</label>
                        <div class="answer-option-list">
                            <div class="row">
                                <label class="col-lg-1 col-form-label text-lg-end">1.</label>
                                <div class="col-lg-11">
                                    <input id="answers" type="text" name="newAnswers[]" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link add-answer-option" data-sequence="1">Tambah Pilihan Jawaban</button>
                    <button class="btn btn-indigo">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
