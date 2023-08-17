<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserWalletController extends Controller
{

    public $userModel;
    public function __construct()
    {

        $this->userModel = new User;
    }

    /**
     * @method Post
     * @return \Illuminate\Http\Response
     * @since
     * @author 
     * 
     */
    public function updateWalletAmount(Request $request)
    {
        try {
            $reqBody = [
                "userId" => $request->input('userId'),
                "amount" => $request->input('amount'),
            ];
            $validator = Validator::make($reqBody, [
                'userId' => 'required|integer',
                'amount' => 'required|min:3|max:100|regex:/^\d+(\.\d{1,2})?$/', //Regex to allow wallet amount upto two decimal places.
            ]);
            if ($validator->fails()) {
                return response()->json(["status" => Response::HTTP_FORBIDDEN, 'message' => $validator->messages()], Response::HTTP_FORBIDDEN);
            }
            $user = User::getUserById($request->input('userId'));
            $totalWalletAmount = $user['wallet'] + $request->input('amount');
            $updateData = array(
                'wallet' => $totalWalletAmount,
            );
            $where = array(
                'id' => $request->input('userId')
            );
            $updateResult = User::UpdateUser($updateData, $where);
            $updatedUser = User::getUserById($request->input('userId'));
            $updatedAmount = $updatedUser['wallet'];
            if (is_int($updateResult)) {
                return response()->json(["status" => Response::HTTP_OK, "message" => "Wallet amount has been updated", "updatedAmount" => $updatedAmount], Response::HTTP_OK);
            } else {
                return response()->json(["status" => Response::HTTP_INTERNAL_SERVER_ERROR, "message" => "database error",], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => response::HTTP_INTERNAL_SERVER_ERROR, 'message' => $e->getMessage()], response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function buyCookie(Request $request)
    {
        try {
            $reqBody = [
                "userId" => $request->input('userId'),
            ];
            $validator = Validator::make($reqBody, [
                'userId' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return response()->json(["status" => Response::HTTP_FORBIDDEN, 'message' => $validator->messages()], Response::HTTP_FORBIDDEN);
            }
            $user = User::getUserById($request->input('userId'));
            $totalWalletAmount = $user['wallet'] - 1;
            $updateData = array(
                'wallet' => $totalWalletAmount,
            );
            $where = array(
                'id' => $request->input('userId')
            );
            $updateResult = User::UpdateUser($updateData, $where);
            $updatedUser = User::getUserById($request->input('userId'));
            $updatedAmount = $updatedUser['wallet'];
            if (is_int($updateResult)) {
                return response()->json(["status" => Response::HTTP_OK, "message" => "Congratulations! you bought a cookie!", "updatedAmount" => $updatedAmount], Response::HTTP_OK);
            } else {
                return response()->json(["status" => Response::HTTP_INTERNAL_SERVER_ERROR, "message" => "database error",], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => response::HTTP_INTERNAL_SERVER_ERROR, 'message' => $e->getMessage()], response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
