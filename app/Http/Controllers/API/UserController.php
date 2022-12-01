<?php
namespace App\Http\Controllers\API;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    /**
     * Login User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $data['id'] = $user->id;
            $data['email'] = $user->email;
            $data['token'] = $user->createToken('vox-teneo')->accessToken;
            return $this->setResponse(Response::HTTP_OK, $data);
        } else {
            return $this->setResponse(Response::HTTP_UNAUTHORIZED, [], 'Invalid Credentials');
        }
    }

    /**
     * Register User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = new User();

        $user->first_name = $request->firstName;
        $user->last_name = $request->lastName;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->setResponse(Response::HTTP_CREATED, $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return $this->setResponse(Response::HTTP_OK, $user);
        }
        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'User not found.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->first_name = $request->firstName;
            $user->last_name = $request->lastName;
            $user->email = $request->email;
            $user->save();

            return $this->setResponse(Response::HTTP_OK, $request->all());
        }
        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'User not found.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return $this->setResponse(Response::HTTP_OK, []);
        }
        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'User not found.');
    }

    /**
     * Update password the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(UserChangePasswordRequest $request, $id)
    {
        $user = User::find($id);

        if ($user) {
            if (!Hash::check($request->oldPassword, $user->password)) {
                return $this->setResponse(Response::HTTP_UNPROCESSABLE_ENTITY, [], [
                    'oldPassword' => [
                        'Old Password does not match.'
                    ]
                ]);
            }

            $user->password = bcrypt($request->newPassword);
            $user->save();

            return $this->setResponse(Response::HTTP_OK, []);
        }
        return $this->setResponse(Response::HTTP_NOT_FOUND, [], 'User not found.');
    }
}
