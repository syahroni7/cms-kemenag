@extends('frontend.layouts.master')

@section('title', $title)

@section('_styles')

@endsection


@section('content')
<section id="org-chart" class="section">
  <div class="container">
    <div class="section-title">
      <h2>Struktur Organisasi</h2>
      <p>Kantor Kementerian Agama</p>
    </div>

    <div class="org-chart">
<ul>
    @foreach ($struktur as $root)
        <x-nodestruktur :node="$root" />
    @endforeach
</ul>

    </div>

  </div>
</section>

@endsection
