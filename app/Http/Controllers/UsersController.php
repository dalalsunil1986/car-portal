<?php namespace App\Http\Controllers;

use App\Src\User\UserRepository;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller {

    /**
     * User Model
     * @var User
     */
    protected $userRepository;

    /**
     * Inject the models.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $id
     * @return redirect to get profile
     * just a RESTful wrapper
     */
    public function show($id)
    {
        return $this->getProfile($id);
    }

    /**
     * Get user's profile
     * @param $id
     * @internal param $username
     * @return mixed
     */
    public function getProfile($id)
    {
        $user = $this->userRepository->model->find($id);
        return view('modile.users.profile', compact('user'));
    }

    /**
     * Edit Profile
     */
    public function edit($id)
    {
        $user = $this->userRepository->findById($id);
        $this->render('site.users.edit', compact('user'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Update Profile
     */
    public function update($id)
    {
        $this->userRepository->findById($id);

        $val = $this->userRepository->getEditForm($id);

        if ( ! $val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( ! $user = $this->userRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->userRepository->errors())->withInput();
        }

        return Redirect::action('UserController@getProfile', $id)->with('success', 'Updated');
    }

    public function destroy($id)
    {
        $user = $this->userRepository->findById($id);

        if ( ! $this->userRepository->delete($user) ) {

            return Redirect::back('/')->with('errors', 'Could Not Delete Account.');
        }

        return Redirect::home()->with('success', 'Account Deleted');

    }


}
