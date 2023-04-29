<div class="card-body bg-light pb-0">
    <form action="{{ route('admin.legislation.law.index') }}" id="filter-form" class="filter-form" method="GET">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <select name="category" id="category" class="select-search">
                        <option value="">Pilih Jenis</option>
                        @foreach ($categories as $key => $value)
                            <option value="{{ $key }}" @selected(Request::get('category') == $key)>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" name="title" placeholder="Judul" value="{{ Request::get('title') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Nomor Peraturan" name="code_number" value="{{ Request::get('code_number') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="number" class="form-control" placeholder="Nomor Urut Peraturan" name="number" value="{{ Request::get('number') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select name="month" class="select">
                        <option value="">Pilih Periode Diundangkan</option>
                        <option value="1" @selected(Request::get('month') == 1)>Januari</option>
                        <option value="2" @selected(Request::get('month') == 2)>Februari</option>
                        <option value="3" @selected(Request::get('month') == 3)>Maret</option>
                        <option value="4" @selected(Request::get('month') == 4)>April</option>
                        <option value="5" @selected(Request::get('month') == 5)>Mei</option>
                        <option value="6" @selected(Request::get('month') == 6)>Juni</option>
                        <option value="7" @selected(Request::get('month') == 7)>Juli</option>
                        <option value="8" @selected(Request::get('month') == 8)>Agustus</option>
                        <option value="9" @selected(Request::get('month') == 9)>September</option>
                        <option value="10" @selected(Request::get('month') == 10)>Oktober</option>
                        <option value="11" @selected(Request::get('month') == 11)>November</option>
                        <option value="12" @selected(Request::get('month') == 12)>Desember</option>
                    </select>
                </div>    
            </div> 
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="number" class="form-control" placeholder="Tahun Diundangkan" name="year" value="{{ Request::get('year') }}">    
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="approved" value="{{ Request::get('approved') }}" placeholder="Tgl. Ditetapkan">
                    </div>
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="published" value="{{ Request::get('published') }}" placeholder="Tgl. Diundangkan">
                    </div>    
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Tempat Penetapan" name="place" value="{{ Request::get('place') }}">    
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Sumber" name="source" value="{{ Request::get('source') }}">    
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Subjek" name="subject" value="{{ Request::get('subject') }}">    
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Bahasa" name="language" value="{{ Request::get('language') }}">    
                </div>    
            </div> 
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="T.E.U. Badan" name="author" value="{{ Request::get('author') }}">    
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Penandatangan" name="signer" value="{{ Request::get('signer') }}">    
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Lokasi" name="location" value="{{ Request::get('location') }}">    
                </div>    
            </div>  
            <div class="col-md-3">
                <div class="mb-3">
                    <select name="status" class="select">
                        <option value="">Pilih Status</option>
                        @foreach ($lawStatusOptions as $status)                            
                            <option value="{{ $status->value }}" @selected(Request::get('status') == $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>  
                </div>    
            </div> 
            <div class="col-md-3">
                <div class="mb-3">
                    <select id="matter" name="matter" class="form-control select-search">
                        <option value="">Pilih Bidang Urusan Pemerintahan</option>
                        @foreach ($matters as $key => $value)                               
                            <option value="{{ $key }}" @selected(Request::get('matter') == $key)>{{ $value }}</option>  
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select id="institute" name="institute" class="form-control select-search">
                        <option value="">Pilih Pemrakarsa</option>
                        @foreach ($institutes as $key => $value)                               
                            <option value="{{ $key }}" @selected(Request::get('institute') == $key)>{{ $value }}</option>  
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select id="field" name="field" class="form-control select-search">
                        <option value="">Pilih Bidang Hukum</option>
                        @foreach ($fields as $key => $value)                               
                            <option value="{{ $key }}" @selected(Request::get('field') == $key)>{{ $value }}</option>  
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar-blank"></i></span>
                        <input type="text" class="form-control daterange-single" name="created_at" value="{{ Request::get('created_at') }}" placeholder="Tgl. Posting">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <input type="checkbox" class="form-check-input mt-0" name="no_master" @checked(Request::get('no_master'))>
                        </span>
                        <input type="text" class="form-control" placeholder="Belum Unggah Batang Tubuh">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <input type="checkbox" class="form-check-input mt-0" name="no_abstract" @checked(Request::get('no_abstract'))>
                        </span>
                        <input type="text" class="form-control" placeholder="Belum Unggah Abstrak">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <select id="user" name="user" class="form-control select-search">
                        <option value="">Pilih Operator</option>
                        @foreach ($users as $key => $value)                               
                            <option value="{{ $key }}" @selected(Request::get('user') == $key)>{{ $value }}</option>  
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <button type="submit" name="filter" value="true" class="btn btn-indigo"><i class="ph-magnifying-glass me-2"></i>Cari</button>
                </div>
            </div>
        </div>

    </form>
</div>

