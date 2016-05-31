<?php

class AuthController extends BackendController {

    public $data = array();

    public function login() {

        if (Request::isMethod("post")) {

            $rules = array(
                'username' => 'required',
                'password' => 'required'
            );

            $validator = Validator::make(Request::all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withErrors($validator)
                                ->withInput(Request::except('password'));
            } else {

                $userdata = array(
                    'username' => Request::get('username'),
                    'password' => Request::get('password'),
                    "status" => 1
                );

                if (Auth::attempt($userdata, Request::get("remember"))) {

                    // fire login event
                    Event::fire("auth.login", Auth::user());

                    if (Request::has("url")) {
                        Session::forget('url');
                        return Redirect::to(Request::get("url"));
                    } else {
                        $redirect_path = Config::get("admin.default_path");
                        return redirect(ADMIN . "/" . trim($redirect_path));
                    }

                } else {
                    return Redirect::route('admin.auth.login')
                                    ->withErrors(array("message" => trans("auth::auth.invalid_login")))
                                    ->withInput(Request::except('password'));
                }
            }
        }

        return View::make("auth::login");
    }

    public function logout() {

        $user = Auth::user();

        Auth::logout();

        // fire logout event
        Event::fire("auth.logout", $user);

        return Redirect::route("admin.auth.login");
    }

    public function forget() {

        if (Request::isMethod("post")) {

            $rules = array(
                'email' => 'required|email'
            );

            $validator = Validator::make(Request::all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                                ->withErrors($validator)
                                ->withInput(Request::all());
            } else {

                $email = Request::get("email");

                // Send activation link to user
                // check user is already exists
                $user = User::where("email", $email)->first();

                if (count($user)) {

                    $code = Str::random(30);
                    $link = URL::route("admin.auth.reset") . "/" . $code;

                    $headers = 'From: "'.Config::get("site_name").'" <' . Config::get("site_email") . '>';

                    $content = trans("auth::auth.hi") . " " . $user->first_name . ", \r\n" . trans("auth::auth.check_password_link") . "\r\n" . $link;
                    mail($user->email, trans("auth::auth.reset_password"), $content, $headers);

                    /*
                      Mail::send("auth::auth.forget_email", array("user" => $user, "link" => $link), function($message) use ($user) {
                      $message->from('info@dotmsr.com', 'دوت مصر')->to($user->email, $user->first_name)->subject(trans("auth::auth.reset_password"));
                      });
                     */

                    User::where("email", $email)
                            ->update(array(
                                "code" => $code
                    ));

                    // fire forget event
                    Event::fire("auth.forget", $user);

                    return Redirect::back()
                                    ->withErrors(array("email_sent" => trans("auth::auth.password_reset_link_sent")))
                                    ->withInput(Request::all());
                } else {
                    return Redirect::back()
                                    ->withErrors(array("not_registed" => trans("auth::auth.email_not_found")))
                                    ->withInput(Request::all());
                }
            }
        }

        return View::make("auth::forget");
    }

    public function reset($code = false, $reseted = false) {

        $this->data["reseted"] = $reseted;

        if ($reseted) {
            return View::make("auth::reset", $this->data);
        }

        if (Request::has("code")) {
            $code = Request::get("code");
        }

        $this->data["code"] = $code;

        $user = User::where("code", $code)->first();

        if (count($user) == 0) {
            return "Forbidden";
        }

        if (Request::isMethod("post")) {

            $rules = array(
                'password' => 'required|min:7',
                /* 'password' => 'required|min:12|alpha_num', */
                'repassword' => 'required|same:password',
            );

            $validator = Validator::make(Request::all(), $rules, [
                        'password.has' => 'كلمة المرور يجب أن تحتوى على حروف كبيرة وحروف صغيرة وأرقام وحروف خاصة'
            ]);

            if ($validator->fails()) {
                return Redirect::route("admin.auth.reset", array("code" => $code))
                                ->withErrors($validator)
                                ->withInput(Request::all());
            } else {

                // Reset user password
                User::where("id", "=", $user->id)
                        ->update(array(
                            "updated_at" => date("Y-m-d H:i:s"),
                            "code" => "",
                            "password" => Hash::make(Request::get("password"))
                ));

                // fire reset password event
                Event::fire("auth.reset", $user);

                return Redirect::to(ADMIN."/auth/reset/" . $code . "/1");
            }
        }

        return View::make("auth::reset", $this->data);
    }

}
