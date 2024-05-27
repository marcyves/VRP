<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $groups = $user->getGroups();

        $occurences = $groups->getGroupOccurences();

        return view('group.index', compact('groups', 'occurences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(String $course_id)
    {
        return view('group.create', compact('course_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, String $course_id)
    {
        $validated = $request->validate([
            'name' => 'required|max:80',
            'short_name' => 'required|min:3',
            'size' => 'required|min:0',
        ]);
        
        $company_id = Auth::user()->company_id;

        try{
            Group::create([
                    'name' => $request->name,
                    'short_name' => $request->short_name,
                    'size' => $request->size,
                    'course_id' => $course_id,
                    'company_id' => $company_id,
                ]);

            session()->flash('success', "Groupe enregistré avec succès.");

            if ($course_id == 0){
                return redirect(route('group.index'));
            }else{
                return redirect(route('course.show', $course_id));
            }
        }
        catch (\Exception $e) {
            dd($e);
            session()->flash('danger', "Erreur lors de l'enregitrement du groupe.");

            return redirect()->back();
        }               
    }

    /**
     * Link the specified group to the current course.
     */
    public function link(String $group_id)
    {
        $course_id = session()->get('course_id');
        GroupCourse::create([
            'course_id' => $course_id,
            'group_id' => $group_id
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $courses = $group->getCourses();

        return view('group.show', compact('courses', 'group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $group_id)
    {
        $group = Group::find($group_id);
        $user = Auth::user();
        $courses = $user->getCourses(now()->format('Y'), 'all');

        return view('group.edit', compact('group', 'courses'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $group_id)
    {
        $validated = $request->validate([
            'name' => 'required|max:80',
            'short_name' => 'required|min:3',
            'size' => 'required|min:0',
        ]);
        
        try{
            $group = Group::findOrFail($group_id);
            $group->name = $request->name;
            $group->short_name = $request->short_name;
            $group->size = $request->size;
            $group->update();

            //TODO add group_course record to link them

            session()->flash('success', "Groupe modifié avec succès.");

            return redirect(route('course.show', $request->course_id));
        }
        catch (\Exception $e) {
            dd($e);
            session()->flash('danger', "Erreur lors de l'enregitrement du groupe.");

            return redirect()->back();
        }               
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $group_id)
    {
        $group = Group::findOrFail($group_id);
        $course_id = $group->course_id;

        $group->delete();

        session()->flash('success', "Groupe effacé avec succès.");

        return redirect(route('course.show', $course_id));
    }
}
