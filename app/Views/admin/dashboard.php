<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin System Control Panel</title>
    <style>
        @import url('https://googleapis.com');
        
        body { font-family: 'Noto Sans Myanmar', sans-serif; background: #F8F6EE; margin: 0; padding: 20px; color: #333; line-height: 1.6; }
        h1, h3 { font-family: 'Noto Serif Myanmar', serif; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #D4AF37; padding-bottom: 10px; margin-bottom: 20px; }
        .stats-grid { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        .stat-card { background: #fff; padding: 20px; border-radius: 12px; flex: 1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center; border: 1px solid #F4D66D; }
        .stat-card h2 { margin: 5px 0; font-size: 2.5rem; color: #D4AF37; font-family: 'Noto Serif Myanmar', serif; }
        .actions { margin-bottom: 30px; background: #032F2E; padding: 15px; border-radius: 12px; }
        .actions h3 { color: #D4AF37; margin-top: 0; }
        .btn { display: inline-block; padding: 10px 15px; background: #D4AF37; color: #032F2E; text-decoration: none; border-radius: 8px; font-weight: bold; margin-right: 10px; border: none; cursor: pointer; font-family: 'Noto Sans Myanmar', sans-serif; }
        .btn:hover { background: #A87C17; }
        .btn-logout { background: #dc3545; color: #fff; }
        .btn-logout:hover { background: #bd2130; }
        .data-tables { display: flex; gap: 20px; flex-wrap: wrap; }
        .table-box { background: #fff; padding: 20px; border-radius: 12px; flex: 1; min-width: 300px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border: 1px solid #F4D66D; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #eee; vertical-align: middle; }
        th { background: #032F2E; color: #D4AF37; }
        
        /* Flash messages styling */
        .alert-success { background: #d4edda; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb; }

        @media (max-width: 768px) {
            .dashboard-header { flex-direction: column; gap: 10px; text-align: center; }
            .stats-grid { flex-direction: column; }
            .stat-card { flex: none; }
            .data-tables { flex-direction: column; }
            .table-box { flex: none; overflow-x: auto; }
            .actions a { display: block; margin: 10px 0 !important; text-align: center; }
        }
    </style>
</head>
<body>
    <?= view('partials/header') ?>
    
    <div style="padding: 20px;">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h1>Welcome Back, <?= esc(session()->get('username')) ?></h1>
            <a href="<?= base_url('logout') ?>" class="btn btn-logout">Logout</a>
        </div>

        <!-- Success Toast Notifications -->
        <?php if (session()->has('success')): ?>
            <div class="alert-success">
                <?= esc(session('success')) ?>
            </div>
        <?php endif; ?>

        <!-- Stats Summary Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Active Properties</h3>
                <h2><?= esc($total_properties) ?></h2>
            </div>
            <div class="stat-card">
                <h3>Total Blog Posts</h3>
                <h2><?= esc($total_posts) ?></h2>
            </div>
        </div>

        <!-- Management Action Center -->
        <div class="actions">
            <h3>Quick Operations</h3>
            <a href="<?= base_url('properties/create') ?>" class="btn">+ Add New Property</a>
            <a href="<?= base_url('posts/create') ?>" class="btn">+ Publish Blog Post</a>
            <a href="<?= base_url('properties') ?>" target="_blank" style="margin-left: 20px; color: #F4D66D;">View Public Listings &rarr;</a>
            <a href="<?= base_url('posts') ?>" target="_blank" style="margin-left: 20px; color: #F4D66D;">View Public Blog &rarr;</a>
        </div>

        <!-- Data Tables Grid Overview -->
        <div class="data-tables">
            
            <!-- Properties Table Box -->
            <div class="table-box">
                <h3>Recent Property Entries</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_properties)): ?>
                            <?php foreach ($recent_properties as $prop): ?>
                            <tr>
                                <td><?= esc($prop['title']) ?></td>
                                <td><?= !empty($prop['location']) ? esc($prop['location']) : 'N/A' ?></td>
                                <td><?= !empty($prop['price']) ? esc($prop['price']) : 'Contact for Price' ?></td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="<?= base_url('properties/edit/' . $prop['id']) ?>" class="btn" style="padding: 5px 10px; font-size: 0.8rem; margin-right: 0;">Edit</a>
                                        <form method="post" action="<?= base_url('properties/delete/' . $prop['id']) ?>" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-logout" style="padding: 5px 10px; font-size: 0.8rem;">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align: center;">No property records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Blog Posts Table Box -->
            <div class="table-box">
                <h3>Recent Blog Posts</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Post Title</th>
                            <th>Excerpts Snippet</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recent_posts)): ?>
                            <?php foreach ($recent_posts as $post): ?>
                            <tr>
                                <td><strong><?= esc($post['title']) ?></strong></td>
                                <td><?= esc(character_limiter($post['content'], 60)) ?></td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="<?= base_url('posts/edit/' . $post['id']) ?>" class="btn" style="padding: 5px 10px; font-size: 0.8rem; margin-right: 0;">Edit</a>
                                        <form method="post" action="<?= base_url('posts/delete/' . $post['id']) ?>" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-logout" style="padding: 5px 10px; font-size: 0.8rem;">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" style="text-align: center;">No blog entries found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>
</html>
