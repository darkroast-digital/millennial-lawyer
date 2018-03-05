<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
    public function view($request, $response, $args)
    {
        return $this->view->render($response, 'admin/users/user.twig');
    }

    public function edit($request, $response, $args)
    {
        $user = $this->auth->user();
        $avatar = '/assets/uploads/avatars/' . $user->id . '/avatar.jpg';

        return $this->view->render($response, 'admin/users/edit.twig', compact('user', 'avatar'));
    }

    public function update($request, $response, $args)
    {
        $params = $request->getParams();
        $password = null;
        $user = $this->auth->user();
        $id = $user->id;

        if (isset($params['password'])) {

            if (isset($params['passwordConfirm'])) {

                if ($params['password'] != $params['passwordConfirm']) {
                    $this->flash->addMessage('error', 'Passwords do not match.');
                    return $response->withRedirect($this->router->pathFor('users.edit', ['id' => $id]));
                } else {
                    $password = $params['password'];
                }

            } else {
                $this->flash->addMessage('error', 'Please confirm your new password.');
                return $response->withRedirect($this->router->pathFor('users.edit'));
            }
        }

        $files = $_FILES;
        $avatar = $files['avatar'];

        $user->name = $params['name'];
        $user->email = $params['email'];

        if ($password != null) {
            $user->password = password_hash($password, PASSWORD_DEFAULT);
        }

        $user->save();

        if (!file_exists(__DIR__ . '/../../../assets/uploads/avatars/' . $id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/avatars/' . $id);
            $user->avatar = $id;
            $user->save();
        }

        move_uploaded_file($avatar['tmp_name'], __DIR__ . '/../../../assets/uploads/avatars/' . $id . '/avatar.jpg');

        $this->flash->addMessage('info', 'User profile updated!');
        return $response->withRedirect($this->router->pathFor('users.view', ['id' => $user->id]));

    }
}

