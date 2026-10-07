<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Dasar CRUD admin. Controller turunan cukup mendefinisikan
 * model, judul, rute, field form, dan kolom tabel.
 *
 * Tipe field: text, textarea, date, number, select (butuh 'opsi'), image, bool.
 */
abstract class CrudController extends Controller
{
    abstract protected function model(): string;
    abstract protected function judul(): string;
    abstract protected function rute(): string;
    /** @return array<string, array{label:string,type:string,rules?:string,opsi?:array,bantuan?:string}> */
    abstract protected function fields(): array;
    /** @return array<string,string> label => atribut */
    abstract protected function kolom(): array;

    protected function urutan(): array
    {
        return ['id', 'desc'];
    }

    /** Kait untuk menambah data sebelum disimpan (mis. slug). */
    protected function sebelumSimpan(array $data, ?object $item): array
    {
        return $data;
    }

    private function tampil(string $view, array $extra = [])
    {
        return view($view, array_merge([
            'judul' => $this->judul(), 'rute' => $this->rute(),
            'fields' => $this->fields(), 'kolom' => $this->kolom(),
        ], $extra));
    }

    public function index()
    {
        [$kolom, $arah] = $this->urutan();
        $items = ($this->model())::orderBy($kolom, $arah)->paginate(15);

        return $this->tampil('admin.crud.index', ['items' => $items]);
    }

    public function create()
    {
        return $this->tampil('admin.crud.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $item = ($this->model())::create($this->ambilData($request, null));

        return redirect()->route('admin.' . $this->rute() . '.index')->with('ok', $this->judul() . ' berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return $this->tampil('admin.crud.form', ['item' => ($this->model())::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $item = ($this->model())::findOrFail($id);
        $item->update($this->ambilData($request, $item));

        return redirect()->route('admin.' . $this->rute() . '.index')->with('ok', $this->judul() . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = ($this->model())::findOrFail($id);
        foreach ($this->fields() as $nama => $f) {
            if ($f['type'] === 'image' && $item->{$nama}) {
                Storage::disk('public')->delete($item->{$nama});
            }
        }
        $item->delete();

        return back()->with('ok', $this->judul() . ' berhasil dihapus.');
    }

    private function ambilData(Request $request, ?object $item): array
    {
        $aturan = [];
        foreach ($this->fields() as $nama => $f) {
            $aturan[$nama] = $f['type'] === 'image'
                ? 'nullable|image|max:2048'
                : ($f['rules'] ?? 'nullable');
        }
        $request->validate($aturan);

        $data = [];
        foreach ($this->fields() as $nama => $f) {
            if ($f['type'] === 'image') {
                if ($request->hasFile($nama)) {
                    if ($item && $item->{$nama}) {
                        Storage::disk('public')->delete($item->{$nama});
                    }
                    $data[$nama] = $request->file($nama)->store('konten', 'public');
                }
            } elseif ($f['type'] === 'bool') {
                $data[$nama] = $request->boolean($nama);
            } else {
                $data[$nama] = $request->input($nama);
            }
        }

        return $this->sebelumSimpan($data, $item);
    }
}
