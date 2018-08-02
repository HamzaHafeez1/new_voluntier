<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Alert;
use App\Friend;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Pagination\Paginator;
use App\Services\ChatManager;
use App\Services\ChatService;
use Firebase\JWT\JWT;

class ChatController extends Controller
{
	//private $private_key = "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDRjPfNzZv/k2hf\n209vjcCMiDO1h6ptI+m7nM+sFVntqRG0p2xoFw7PDUG2nELbh3jQM9nJo80As2zU\nUogbC/dabYqoxI60QTNVv/o/1h9rQZuC/Ach4FcKi+XE5fCBtb16+E19MBpJ2UsD\n8GZPK2uQXVM/nfxlthjoy1Mf/vXFzvc4W2ycjwJ1BPjYuaAgJ6ArNJ5TrUobbmaL\nru2CacTV1MEdkmPEjXdtKrAGIVFRoesEB7llDvd5caNect6OvbNDVoUaPcESlnpp\nwdPiAc5vRhOZqcwOiNh5V32fNbwnXV6jnHd2Hc0fJOiIagVolYeELkL0G0KKrxXO\nb8+1FJyBAgMBAAECggEAQ3e0Jz5uXgyrW8WEH2IP3w9ROr6p2Abqj72uvXSIZjT7\nnuMSy7a0zWQyxqUr/3twIfS3x6yl6fZa8Ud7S93/70z6iljyq0WczhyH6Xq61fEj\nLTqQ307YJ2ygd1MjKtgFYCzG4ioVJLbB6MxDXHUZ5jqt/XsT0vmcroMcSd5wahWi\nAU2Wu8/4CeooLf3jtqKb1OaP4m85V2OffcSFAebp0ZVAlq87R8bqfNDqehIfkVu6\nEWQwQhbPTQsAC44vDLqI7jcR7IpKIQvguQAQ1Fy9WSC3A8rwPkdgn0kIGu2MvakQ\n3RfamlYXVPvHFmNYBJl/cbEeLLtSjVUyz8f1FgsMMwKBgQDy/V9l7UpzzoO1+gHY\neFoqGHiqynXpoR4ygo8Sidg+ApwHgd7/KpQ2n2EM1apPXQOqQMy25ojB5FFMQ7M6\nV3VqA8IAxbD/v2BOm/tdlDSdhEZCgs8rja79ycQ/img1TVvS+NgG7+p6bJsfCJec\nGVpn7WBamW7+OGudAulYvnG8XwKBgQDcxUAZw5lpw2I+WU8cb72ovnztEDsGfxHT\nbsBgQKd3J/czrFYjOdDZV4Wk081mn90Wb/A5RlgjRsifMETLHp27l+RYtPOOoCxp\n04EaafQ2Yp44zZlcNqEmBrI3x2oTSB9GmGVvLmhxWVuLJhj02FbTxXVyHQ75BpQa\nJOz9xERTHwKBgQDLfAdBsh9hL5X49K5K+y52hhu22uk3hudk4RSzL6BY/ZJwbv+x\nq5SG0Z1SRDPlVj1VfAJzQEdSJ8M1HJSgzNDUwOTcBLGe2kLqUZGE4jHVnwm/dQ/M\np0/d0/N2So/N40R8PkuaM5umfgDBUk60OD8PPSgtdsQOPG1SBTgoSwOv/QKBgQDc\npHrzBO0fqflXLPUHC5p2uqKqX01OqdLMCGVWDWgRi6zhRPz1ycO0ZGeaG2Cuj1ls\nIkXpSCewYf8CMkCe7KNiKGU8TuUYh3a78XmXR4ueiyNsy/bZFXQrSAf3/WJDkRJJ\nAOhnnO8fUdpPEK1ij5D/p9pASVB8jBmao4sD+JL8qwKBgAUb6F5t0KwQIz4vLF1x\nQa3PQmuO8Ct3otKYV4yr17aj0ubCwqVtvpBM+/ZNUsZY4cBBLpl7OP8peuTydMEP\nBFFHztLpq0udQqGxCY0PewNPodU46QrXlsttYza3gIUBIcufJO2i124dE1ZmCIQM\nJgDI/gUJFPmabKkQDB7ZRFqg\n-----END PRIVATE KEY-----\n";
    public function index(Request $request)
    {
//        $service_account_email = "myvoluntierproject-cd034@appspot.gserviceaccount.com";


//        $this->create_custom_token('test-auth-user');

	    if(isset($request->create) && $request->create == true)
	    {
	    	$chatId = $request->chatId;
		    $chat = DB::table( 'user_chat' )->where( 'chat_id', $chatId )->select( '*' )->first();
		    if ( $chat != null )
		    {
			    DB::table( 'user_chat' )->where( 'chat_id', $chatId )->update( [ 'status' => 0 ] );
			    $chatService = new ChatService();
			    $chatManager = new ChatManager();
			    $opponent    = User::find( $request->opponent );
			    $name = $chatManager->getNameUser($opponent);
			    $chatService->addUserToChat( Auth::user(), $chatId, $name, 'friends' );
		    } else
		    {
			    $chatManager = new ChatManager();
			    $chatManager->join( $request->opponent );
		    }
		    if($chatId == null)
		    {
			    $chatId = DB::table( 'user_chat' )->where( 'user_id', $request->opponent )->where('to_user_id', Auth::user()->id)->select( 'chat_id' )->first()->chat_id;
		    }
		    return redirect(Route::getFacadeRoot()->current()->uri() . '?chatId=' . $chatId);
	    }
        return view('chat');
    }

    function create_custom_token($uid) {
        $now_seconds = time();
        $payload = array(
            "iss" => config('services.firebase')['service_account'],
            "sub" => config('services.firebase')['service_account'],
            "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
            "iat" => $now_seconds,
            "exp" => $now_seconds+(60*60),  // Maximum expiration time is one hour
            "uid" => $uid
        );

        return JWT::encode($payload, config('services.firebase')['private_key'], "RS256");
    }

	public function deleteChat($chatId)
	{
		$chat = DB::table('user_chat')->where('chat_id', $chatId)->select('*')->first();
		if($chat != null)
		{
			if ( $chat->status == 0 )
			{
				if ( $chat->user_id == Auth::user()->id )
				{
					DB::table( 'user_chat' )->where( 'chat_id', $chatId )->update( [ 'status' => 1 ] );
				} elseif ( $chat->to_user_id == Auth::user()->id )
				{
					DB::table( 'user_chat' )->where( 'chat_id', $chatId )->update( [ 'status' => 2 ] );
				}
			}
			if ( $chat->status == 1 )
			{
				if ( $chat->to_user_id == Auth::user()->id )
				{
					DB::table( 'user_chat' )->where( 'chat_id', $chatId )->delete();
				}
			}
			if ( $chat->status == 2 )
			{
				if ( $chat->user_id == Auth::user()->id )
				{
					DB::table( 'user_chat' )->where( 'chat_id', $chatId )->delete();
				}
			}
		}
	}
}
