<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Post;
use PHPMailer\PHPMailer\PHPMailer;

class HomeController extends Controller
{
    public function index($request, $response, $args)
    {
        $recent = Post::orderBy('created_at', 'desc')->limit(3)->get();
        $popular = Post::orderBy('post_views', 'desc')->limit(3)->get();
        return $this->view->render($response, 'home.twig', compact('recent', 'popular'));
    }

    public function viewPost($request, $response, $args)
    {
        $post = Post::where('slug', $args['slug'])->first();
        $post->post_views += 1;
        $post->save();

        $files = [];

        if (count(glob(__DIR__ . '/../../assets/uploads/posts/' . $post->id . '/files/*'))) {
            $scan = scandir(__DIR__ . '/../../assets/uploads/posts/' . $post->id . '/files');
            unset($scan[0]);
            unset($scan[1]);

            foreach ($scan as $file) {
                array_push($files, $file);
            }
        }

        return $this->view->render($response, 'post.twig', compact('post', 'files'));
    }

    public function archive($request, $response, $args)
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return $this->view->render($response, 'archive.twig', compact('posts'));
    }

    public function post($request, $response, $args)
    {
        $mail = new PHPMailer;

        $params = $_POST;
        $name = $params['name'];
        $email = $params['email'];
        $message = $params['message'];
        
        $subject = 'New message from ' . $name . ' via your Millennial Lawyer Website';

        $mail->setFrom($email, $name);
        $mail->addAddress('kim@darkroast.co', 'Millennial Lawyer Website');
        $mail->addReplyTo('kim@darkroast.co', 'Millennial Lawyer Website');
        $mail->ReturnPath='kim@darkroast.co';

        $mail->isHTML(true);

        $body = "<p>Name: " . $name . "<br/>" .
                "Email: " . $email . "<br/>" .
                "Message: " . $message;

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $body;

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Success!';
        }
    }
}
