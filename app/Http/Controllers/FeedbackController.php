<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackQuestion;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = FeedbackQuestion::get();
        return view('feedback.index', ['data' => $feedback]);
    }
    public function tambah(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string|max:255',
        ]);
        $this->postFeedbackQuestion(
            $validated['text']
        );
        return redirect()->route('feedback.index')->with('success', 'Data peserta berhasil disimpan.');
    }

    private function postFeedbackQuestion($text) { 
        try { 
            $token = session('api_token');
            Log::info('Token in postUser: ' . $token);
            $url = config('app.api_base_url');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($url . '/feedback/question/+', [ 
                'text'=> $text,
            ]); 
                    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) {
                FeedbackQuestion::create([
                    'text' => $text,
                ]);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
    public function update($id, Request $request)
    {
        $this->updateFeedbackQuestion($id, $request->text);
        return redirect()->route('feedback.index')->with('success', 'Data peserta berhasil disimpan.');
    }

    private function updateFeedbackQuestion($id, $text) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->put($url . '/feedback/question/update/'.$id, [ 
                'text' => $text,
            ]); 
    
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                Log::info('success');
                $feedback = FeedbackQuestion::findOrFail($id);
                $feedback->update([
                    'text' => $text,
                ]);

                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
    public function hapus($id)
    {
        $this->deleteFeedbackquestion($id);
        return redirect()->route('feedback.index')->with('success', 'Data peserta berhasil dihapus.');
    }

    private function deleteFeedbackquestion($id) { 
        try { 
            Log::info('halo');
            $url = config('app.api_base_url');
            $token = session('api_token');
            Log::info('Token from session: ' . $token);
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->delete($url . '/feedback/question/delete/' . $id,);
            Log::info('Response: ' . $response->body());
            if ($response->successful()) { 
                $feedback = FeedbackQuestion::findOrFail($id);
                $feedback->delete();
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) { 
            return false;
        } 
    }
}
