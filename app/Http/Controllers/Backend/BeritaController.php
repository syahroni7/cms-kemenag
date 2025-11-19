<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $data = Berita::latest()->get();
        return view('backend.admin.berita.index', compact('data'));
    }

    public function create()
    {
        return view('backend.admin.berita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required',
        ]);

        Berita::create([
            'judul' => $request->judul,
            'isi'   => $request->isi,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('backend.admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi'   => 'required',
        ]);

        $berita = Berita::findOrFail($id);

        $berita->update([
            'judul' => $request->judul,
            'isi'   => $request->isi,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate.');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
