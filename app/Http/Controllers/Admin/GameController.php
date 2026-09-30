<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::query();
        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }
        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%');
        }

        $games = $query->latest()->paginate(15)->withQueryString();
        $platforms = Game::distinct()->orderBy('platform')->pluck('platform');

        return view('admin.games.index', compact('games', 'platforms'));
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(GameRequest $request)
    {
        $data = $this->gameData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('games', 'public');
            $data['image_url'] = null;
        }

        Game::create($data);

        return redirect()->route('admin.games.index')->with('success', 'Game created.');
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(GameRequest $request, Game $game)
    {
        $data = $this->gameData($request);

        if ($request->hasFile('image')) {
            $this->deleteUploadedImage($game);
            $data['image_path'] = $request->file('image')->store('games', 'public');
            $data['image_url'] = null;
        } elseif ($request->boolean('remove_image')) {
            $this->deleteUploadedImage($game);
            $data['image_path'] = null;
            $data['image_url'] = null;
        }

        $game->update($data);

        return redirect()->route('admin.games.index')->with('success', 'Game updated.');
    }

    public function destroy(Game $game)
    {
        if ($game->orderItems()->exists()) {
            $game->update(['status' => 'inactive']);
            return back()->with('success', 'Game has order history, so it was deactivated instead of deleted.');
        }

        $this->deleteUploadedImage($game);
        $game->delete();

        return back()->with('success', 'Game deleted.');
    }

    public function toggle(Game $game)
    {
        $game->update(['status' => $game->status === 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'Game status updated.');
    }

    private function gameData(GameRequest $request): array
    {
        return $request->safe()->except(['image', 'remove_image']);
    }

    private function deleteUploadedImage(Game $game): void
    {
        if ($game->image_path && Storage::disk('public')->exists($game->image_path)) {
            Storage::disk('public')->delete($game->image_path);
        }
    }
}
