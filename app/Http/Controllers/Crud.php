<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class Crud extends Controller
{
    public function add(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'source' => 'nullable|string',
            'img' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        // Handle image upload (saving to public/projects)
        $imageName = null;
        if ($request->hasFile('img')) {
            $imageName = time() . '.' . $request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(public_path('projects'), $imageName);
        }

        // Create the project record
        Project::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'source_code' => $validatedData['source'],
            'image' => $imageName, // Store only the filename in the DB
        ]);

        return redirect()->back()->with('success', 'Project added successfully');
    }

    public function display()
    {
        $data = Project::all();
        return view('webpage.dashboard', compact('data'));
    }
    public function delete($id){
        Project::findorFail($id)->delete();
        return redirect()->back()->with('success','Project deleted successfully');
    }
    public function showSpesificData($id){
        Project::findorFail($id);

    }
    public function save(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'source' => 'nullable|string',
        'img' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
    ]);

    $project = Project::find($request->project_id) ?? new Project();

    $project->title = $validatedData['title'];
    $project->description = $validatedData['description'];
    $project->source_code = $validatedData['source'];

    if ($request->hasFile('img')) {
        $imageName = time() . '.' . $request->file('img')->getClientOriginalExtension();
        $request->file('img')->move(public_path('projects'), $imageName);
        $project->image = $imageName;
    }

    $project->save();
    return redirect()->back()->with('success','Project updated successfully');
}

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }
    
    public function guest(){
        $data=Project::all();
        return view('webpage.dashboard',compact('data'));
    }

}
