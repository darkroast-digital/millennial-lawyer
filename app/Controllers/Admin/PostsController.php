<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class PostsController extends Controller
{
    public function index($request, $response, $args)
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return $this->view->render($response, 'admin/posts/index.twig', compact('posts'));
    }

    public function show($request, $response, $args)
    {
        $post = Post::where('slug', $args['slug'])->first();
        $featured = null;
        $id = $post->id;
        $slug = $args['slug'];

        if (file_exists(__DIR__ . '/../../../assets/uploads/posts/' . $id . '/featured.jpg')) {
            $featured = '/assets/uploads/posts/' . $id . '/featured.jpg';
        }

        $files = [];

        if (count(glob(__DIR__ . '/../../../assets/uploads/posts/' . $id . '/files/*'))) {
            $scan = scandir(__DIR__ . '/../../../assets/uploads/posts/' . $id . '/files');
            unset($scan[0]);
            unset($scan[1]);

            foreach ($scan as $file) {
                array_push($files, $file);
            }
        }

        $post->body = $this->markdown->text($post->body);

        return $this->view->render($response, 'admin/posts/post.twig', compact('post', 'featured', 'files'));
    }

    public function create($request, $response, $args)
    {
        return $this->view->render($response, 'admin/posts/create.twig');
    }

    public function store($request, $response, $args)
    {
        $check = Post::where('title', $request->getParam('title'))->exists();
        
        if ($check == true) {
            $this->flash->addMessage('error', 'A post with this title already exists. The title must be unique.');
            return $response->withRedirect($this->router->pathFor('posts.create'));
        }

        $user = $this->auth->user();
        $params = $request->getParams();
        $image = $_FILES['featured'];

        if (isset($_FILES['files'])) {
            $files = $_FILES['files'];
            $total = count($files['name']);
        }

        $slug = $this->slug->slugify($params['title']);
        $draft = false;

        if (isset($params['draft'])) {
            $draft = true;
        }

        $post = Post::create([
            'title' => $params['title'],
            'slug' => $slug,
            'body' => $params['body'],
            'author' => $params['author'],
            'draft' => $draft,
            'keywords' => $params['keywords'],
            'ogtitle' => $params['ogtitle'],
            'ogdesc' => $params['ogdesc']
        ]);

        $post->save();

        $id = $post->id;
        $basePath = __DIR__ . '/../../../assets/uploads/posts/' . $id;

        if (isset($image)) {
            if (!file_exists($basePath)) {
                mkdir($basePath);
            }

            move_uploaded_file($image['tmp_name'], $basePath . '/featured.jpg');
            
            if (getimagesize($basePath . '/featured.jpg')[0] > 1920) {
                Image::configure();
                $img = Image::make($basePath . '/featured.jpg');
                $img->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($basePath . '/featured.jpg');
            }

            $post->featured = $id;
            $post->save();

            if (!file_exists($basePath . '/files/')) {
                mkdir($basePath . '/files/');
            }

            for ($i = 0; $i < $total; $i++) {
                $filePath = $basePath . '/files/' . $files['name'][$i];
                move_uploaded_file($files['tmp_name'][$i], $filePath);
            }
        }

        $this->flash->addMessage('info', 'Post Created!');

        return $response->withRedirect($this->router->pathFor('posts.index'));
    }

    public function edit($request, $response, $args)
    {
        $post = Post::where('id', $args['id'])->first();

        return $this->view->render($response, 'admin/posts/edit.twig', compact('post'));
    }

    public function update($request, $response, $args)
    {
        $params = $request->getParams();
        $files = $_FILES;
        $image = $files['featured'];
        $post = Post::where('id', $args['id'])->first();
        $id = $post->id;
        $slug = $this->slug->slugify($params['title']);
        $draft = false;

        if (isset($params['draft'])) {
            $draft = true;
        }

        $check = Post::where('title', $request->getParam('title'))->exists();
        
        if ($check == true) {
            $this->flash->addMessage('error', 'A post with this title already exists. The title must be unique.');
            return $response->withRedirect($this->router->pathFor('posts.edit'));
        }

        $post->title = $params['title'];
        $post->slug = $slug;
        $post->body = $params['body'];
        $post->author = $params['author'];
        $post->draft = $draft;
        $post->keywords = $params['keywords'];
        $post->ogtitle = $params['ogtitle'];
        $post->ogdesc = $params['ogdesc'];

        $post->save();

        if (!file_exists(__DIR__ . '/../../../assets/uploads/posts/' . $id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/posts/' . $id);
            $post->featured = $id;
            $post->save;
        }

        move_uploaded_file($image['tmp_name'], __DIR__ . '/../../../assets/uploads/posts/' . $id . '/featured.jpg');

        $basePath = __DIR__ . '/../../../assets/uploads/posts/' . $id;
        
        if (getimagesize($basePath . '/featured.jpg')[0] > 1920) {
            Image::configure();
            $img = Image::make($basePath . '/featured.jpg');
            $img->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($basePath . '/featured.jpg');
        }

        $this->flash->addMessage('info', 'Post Updated!');
        return $response->withRedirect($this->router->pathFor('posts.view', ['slug' => $post->slug]));
    }

    public function delete($request, $response, $args)
    {
        $post = Post::where('id', $args['id'])->first();

        return $this->view->render($response, 'admin/posts/delete.twig', compact('post'));
    }

    public function trash($request, $response, $args)
    {
        $post = Post::where('id', $args['id']);
        $post->delete();

        $this->flash->addMessage('info', 'Post Deleted!');
        return $response->withRedirect($this->router->pathFor('posts.index'));
    }
}
