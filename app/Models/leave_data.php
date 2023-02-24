<?php

namespace App\Models;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class leave_data extends Model
{
    use HasFactory;

    protected $table = 'leave_data';

    protected $primaryKey = 'auto_id';

    protected $fillable = ['proof'];

    public static function storeFile($file)
    {
        // $filename = $file->getClientOriginalName();
        // $mime_type = $file->getClientMimeType();
        $data = file_get_contents($file);

        return static::create([
            // 'name' => $filename,
            // 'mime_type' => $mime_type,
            'proof' => $data,
        ]);
    }
}
