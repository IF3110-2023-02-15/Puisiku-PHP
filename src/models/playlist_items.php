<?php

require_once 'models.php';

class PlaylistItemsModel extends Models
{
    public function getPlaylistPoems($playlistId)
    {
        $sql = '
            SELECT Poems.id, Poems.title, Poems.genre, Users.username AS creator_name, Poems.year
            FROM PlaylistItems
            JOIN Poems ON PlaylistItems.poem_id = Poems.id
            JOIN Users ON Poems.creator_id = Users.id
            WHERE PlaylistItems.playlist_id = ?
            ORDER BY PlaylistItems.created_at DESC
        ';

        return $this->db->query($sql, [$playlistId])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPlaylistPoem($playlistId, $poemId) {
        $sql = '
            INSERT INTO PlaylistItems VALUES (?,?)
        ';

        return $this->db->query($sql, [$playlistId, $poemId])->fetch(PDO::FETCH_ASSOC);
    }

    public function getPair($playlistId, $poemId) {
        $sql = '
            SELECT * FROM PlaylistItems WHERE playlist_id = ? AND poem_id = ?
        ';

        return $this->db->query($sql, [$playlistId, $poemId])->fetch(PDO::FETCH_ASSOC);
    }
}