<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    //
    public function destroy($id)
    {
        $attachment = Attachments::findOrFail($id);

        // Delete file from storage
        Storage::disk('public')->delete($attachment->file_path);

        // Delete from DB
        $attachment->delete();

        return response()->json(['status' => 'success', 'message' => 'Attachment deleted successfully']);
    }
}
