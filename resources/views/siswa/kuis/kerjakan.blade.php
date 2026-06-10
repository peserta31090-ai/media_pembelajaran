@extends('layouts.siswa')
@section('title', 'Kerjakan Kuis')

@section('content')
<h4 class="page-title">{{ $kuis->judul }}</h4>

<form action="{{ route('siswa.kuis.submit', $kuis->id) }}" method="POST" id="kuisForm">
    @csrf
    <div class="row g-3">
        @foreach($soal as $i => $s)
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6>Soal {{ $i + 1 }}</h6>
                        <p>{{ $s->pertanyaan }}</p>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="jawaban_{{ $s->id }}" value="a" id="q{{ $s->id }}_a" required>
                            <label class="form-check-label" for="q{{ $s->id }}_a">A. {{ $s->opsi_a }}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="jawaban_{{ $s->id }}" value="b" id="q{{ $s->id }}_b">
                            <label class="form-check-label" for="q{{ $s->id }}_b">B. {{ $s->opsi_b }}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="jawaban_{{ $s->id }}" value="c" id="q{{ $s->id }}_c">
                            <label class="form-check-label" for="q{{ $s->id }}_c">C. {{ $s->opsi_c }}</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="jawaban_{{ $s->id }}" value="d" id="q{{ $s->id }}_d">
                            <label class="form-check-label" for="q{{ $s->id }}_d">D. {{ $s->opsi_d }}</label>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12">
            <button type="submit" class="btn btn-success btn-lg w-100" onclick="return confirm('Yakin ingin mengumpulkan kuis?')"><i class="bi bi-check-lg"></i> Kumpulkan Jawaban</button>
        </div>
    </div>
</form>
@endsection
