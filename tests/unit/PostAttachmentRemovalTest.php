<?php

use App\Models\PostModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class PostAttachmentRemovalTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    private string $testFileAbs = '';
    private string $testFilePath = '';

    protected function setUp(): void
    {
        parent::setUp();

        $dir = ROOTPATH . 'public/uploads/blog/';
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    protected function tearDown(): void
    {
        $file = $this->testFileAbs;
        if (is_file($file)) {
            unlink($file);
        }
        parent::tearDown();
    }

    public function testEditRemovesAttachmentAndDeletesFile(): void
    {
        $model = new PostModel();
        $this->testFileAbs = ROOTPATH . 'public/uploads/blog/test_attachment_' . bin2hex(random_bytes(4)) . '.jpg';
        $this->testFilePath = '/uploads/blog/' . basename($this->testFileAbs);
        file_put_contents($this->testFileAbs, 'fake-image-content');

        $id = $model->insert([
            'title'   => 'Removal Test',
            'content' => 'body',
            'images'  => json_encode([
                ['path' => $this->testFilePath, 'name' => 'remove-me.jpg'],
                ['path' => '/uploads/blog/existing.jpg', 'name' => 'existing.jpg'],
            ]),
        ]);
        $this->assertIsInt($id);

        $this->withSession(['isAdminLoggedIn' => true])
            ->post("posts/edit/{$id}", [
                'remove'  => [$this->testFilePath],
                'title'   => 'Removal Test',
                'content' => 'body',
            ])
            ->assertStatus(302);

        $updated = $model->find($id);
        $images = json_decode($updated['images'], true);
        $this->assertIsArray($images);
        $this->assertCount(1, $images);
        $this->assertSame('/uploads/blog/existing.jpg', $images[0]['path']);

        $this->assertFileDoesNotExist($this->testFileAbs);
    }

    public function testEditKeepsAttachmentsWhenNothingRemoved(): void
    {
        $model = new PostModel();
        $this->testFileAbs = ROOTPATH . 'public/uploads/blog/test_attachment_' . bin2hex(random_bytes(4)) . '.jpg';
        $this->testFilePath = '/uploads/blog/' . basename($this->testFileAbs);
        file_put_contents($this->testFileAbs, 'fake-image-content');

        $id = $model->insert([
            'title'   => 'Removal Test 2',
            'content' => 'body',
            'images'  => json_encode([
                ['path' => $this->testFilePath, 'name' => 'keep.jpg'],
            ]),
        ]);
        $this->assertIsInt($id);

        $this->withSession(['isAdminLoggedIn' => true])
            ->post("posts/edit/{$id}", [
                'title'   => 'Removal Test 2',
                'content' => 'body',
            ])
            ->assertStatus(302);

        $updated = $model->find($id);
        $images = json_decode($updated['images'], true);
        $this->assertIsArray($images);
        $this->assertCount(1, $images);
        $this->assertSame($this->testFilePath, $images[0]['path']);

        $this->assertFileExists($this->testFileAbs);
    }
}
