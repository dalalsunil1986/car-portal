<?php namespace App\Http\Controllers;

use App\Src\User\UserRepository;
use Auth;
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
        Auth::loginUsingId(2);
    }

    /**
     * @param $id
     * @return redirect to get profile
     * just a RESTful wrapper
     */
    public function show($id)
    {
        $user = $this->userRepository->model->find($id);
        dd($user);

        return $this->getProfile($id);
    }

    /**
     * Get user's profile
     * @internal param $username
     * @return mixed
     */
    public function getProfile()
    {
        $user = $this->userRepository->model->with(['cars.model.brand', 'cars.thumbnail', 'favorites', 'notifications'])->find(Auth::user()->id);

        foreach ( $user->notifications as $notification ) {
//            foreach ( $notification->filterOfType('CarMake') as $a ) {
//                dd($a->filterable->name);
//            }

//            dd($notification->filterOfType('CarMake'));
        }

        return view('module.users.profile', compact('user'));
    }

    /**
     * Edit Profile
     * @param $id
     */
    public function edit($id)
    {
        $user = $this->userRepository->model->find($id);
        $this->render('site.users.edit', compact('user'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * Update Profile
     */
    public function update($id)
    {
        $this->userRepository->model->find($id);

        $val = $this->userRepository->getEditForm($id);

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        if ( !$user = $this->userRepository->update($id, $val->getInputData()) ) {

            return Redirect::back()->with('errors', $this->userRepository->errors())->withInput();
        }

        return Redirect::action('UserController@getProfile', $id)->with('success', 'Updated');
    }

    /**
     * @param $id
     * @return mixed
     * Deactive a user
     * @todo: remove the dd
     */
    public function destroy($id)
    {
        dd('deleted user with id ' . $id);
        $user = $this->userRepository->model->find($id);

        if ( !$user->delete() ) {

            return Redirect::back('/')->with('errors', 'Could Not Delete Account.');
        }

        return Redirect::home()->with('success', 'Account Deleted');

    }


}
