<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Xcoin;
use App\Models\Like;
use App\Models\Post;

use App\Http\Controllers\Controller;

class XcoinController extends Controller
{
        public function index()
    {
         $user = auth('sanctum')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $xcoins = Xcoin::where('user_id', $user->id)->sum('amount');
        return response()->json([
            'success' => true,
            'data' => $xcoins,
            'message' => 'Xcoins retrieved successfully'
        ]);
       
    }
/*SELECT * FROM xclusif.likes l inner join posts p on p.id = l.post_id; y borrar 
todos los likes involucrados en los posts para a su vez retirar ganancias*/
//     public function destroy(){
//         $user = auth('sanctum')->user();
//         if (!$user) {
//             return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
//         }
//         try {
//             Xcoin::where('user_id', $user->id)->delete();
//             Like::where('user_id', $user->id)->delete();
//                 return response()->json([
//                     'success' => true,
//                     'message' => 'Xcoins reset successfully'
//                 ]);
           
//         } catch (Exception $e) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Error resetting Xcoins: ' . $e->getMessage()
//             ], 500);
//         }
//     }
}
