<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Feedback;
use App\Models\FeedbackQuestion;
use App\Models\Jawaban;
use App\Models\JawabanBenar;
use App\Models\OpsiJawaban;
use App\Models\Question;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index($id): JsonResponse
    {
        $data = Exam::where('id_pelatihan', $id)->get();
        if ($data->count() > 0) {
            return response()->json([
                'statusCode' => 200,
                'message' => 'Success',
                'data' => $data
            ], 200);
        }
        else{
            return response()->json([
                'statusCode' => 401,
                'message' => 'Question not found',
            ], 401);
        }
    }
    public function menjawab(Request $request, $id = null): JsonResponse
    {

        $jb = JawabanBenar::where('id_question', $request->id_question)->first();
        $selectedoption = OpsiJawaban::find($request->id_opsi_jawaban);
        $is_benar = $jb->text == $selectedoption->jawaban ? 'benar' : 'salah';

        if ($id) {
            Jawaban::where('id', $id)->update([
                'jawaban_benar' => $jb->id,
                'id_pelaksanaan_pelatihan' => $request->id_pelaksanaan_pelatihan,
                'id_opsi_jawaban' => $request->id_opsi_jawaban,
                'id_peserta' => $request->id_peserta,
                'id_question' => $request->id_question,
                'is_benar' => $is_benar
            ]);
        } else {
            Jawaban::create([
                'jawaban_benar' => $jb->id,
                'id_pelaksanaan_pelatihan' => $request->id_pelaksanaan_pelatihan,
                'id_opsi_jawaban' => $request->id_opsi_jawaban,
                'id_peserta' => $request->id_peserta,
                'id_question' => $request->id_question,
                'is_benar' => $is_benar
            ]);
        }

        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
        ], 200);
    }
   
    public function feedback(Request $request){
        Feedback::create([
            'id_user' => $request->id_user,
            'id_feedbackQuestion' => $request->id_feedbackQuestion,
            'text' => $request->text,
            'id_pelaksanaanPelatihan' => $request->id_pelaksanaanPelatihan,
        ]);

        return response()->json([
            'statusCode' => 200,
            'message' => 'Success',
        ], 200);
    }
    
}
