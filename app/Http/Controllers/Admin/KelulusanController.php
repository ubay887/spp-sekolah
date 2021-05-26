 <?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        if (!empty($request->kelas_id)) {
            $siswa = Siswa::with('kelas')->where('kelas_id', $request->kelas_id)->where('status','Aktif')->orderBy('nama_lengkap', 'ASC')->get();
            // return view('admin.kenaikan_kelas.index', \compact('kelas', 'siswa'));
        }else{
            $siswa = Siswa::with('kelas')->where('kelas_id', '12')->whereStatus('aktif')->orderBy('nama_lengkap', 'ASC')->get();
        }
        // return $siswa;
        return view('admin.kelulusan.index', \compact('kelas', 'siswa'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataAlumni(Request $request)
    {
        $siswa = Siswa::with('kelas')->where('status', 'Lulus')->orderBy('nama_lengkap', 'ASC')->get();
        // return $siswa;
        return view('admin.kelulusan.alumni', \compact('siswa'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataDikeluarkan(Request $request)
    {
        $siswa = Siswa::with('kelas')->where('status', 'Dikeluarkan')->orderBy('nama_lengkap', 'ASC')->get();
        // return $siswa;
        return view('admin.kelulusan.dikeluarkan', \compact('siswa'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataPindah(Request $request)
    {
        $siswa = Siswa::with('kelas')->where('status', 'Pindah')->orderBy('nama_lengkap', 'ASC')->get();
        // return $siswa;
        return view('admin.kelulusan.pindah', \compact('siswa'));
    }

    public function prosesKelulusan(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'status' => 'required',
            'siswa_id' => 'required',
        ]);

        // dd($request->all());

        foreach($request->siswa_id as $item){
            $siswa = Siswa::findOrFail($item);
            $siswa->status = $request->status;
            $siswa->update();
        }

        session()->flash('success', "Data Berhasil Disimpan");

        // return redirect("/kenaikanKelas?kelas_id=$request->kelas_id");

        return redirect(route('kelulusan.index'));
    }
}
