<?php

/**
 * SiteMeta - 站点元信息管理
 * 
 * 包含站点元数据配置与描述文本生成方法。
 * 基于数组存储，支持自定义关键词与链接。
 */

class SiteMeta {

    private array $meta;
    private string $separator;

    public function __construct(array $data = [], string $separator = ' - ') {
        $this->meta = $data;
        $this->separator = $separator;
    }

    /**
     * 设置站点元信息
     */
    public function setMeta(string $key, $value): void {
        $this->meta[$key] = $value;
    }

    /**
     * 获取指定键的值
     */
    public function getMeta(string $key): ?string {
        return $this->meta[$key] ?? null;
    }

    /**
     * 生成简短的描述文本（用于SEO或摘要）
     */
    public function generateDescription(): string {
        $parts = [];

        if (!empty($this->meta['title'])) {
            $parts[] = $this->meta['title'];
        }

        if (!empty($this->meta['keywords'])) {
            $parts[] = implode(', ', $this->meta['keywords']);
        }

        if (!empty($this->meta['description'])) {
            $parts[] = $this->meta['description'];
        }

        if (!empty($this->meta['url'])) {
            $parts[] = $this->meta['url'];
        }

        return implode($this->separator, $parts);
    }

    /**
     * 输出带转义的HTML元标签（示例用法）
     */
    public function renderMetaTags(): void {
        $description = htmlspecialchars($this->generateDescription(), ENT_QUOTES, 'UTF-8');
        echo '<meta name="description" content="' . $description . '" />' . "\n";

        if (!empty($this->meta['keywords'])) {
            $keywords = htmlspecialchars(implode(', ', $this->meta['keywords']), ENT_QUOTES, 'UTF-8');
            echo '<meta name="keywords" content="' . $keywords . '" />' . "\n";
        }
    }

    /**
     * 返回所有元数据的副本
     */
    public function getAll(): array {
        return $this->meta;
    }
}

// ===== 示例配置 =====

$siteMeta = new SiteMeta([
    'title'       => '爱游戏官方平台',
    'url'         => 'https://cn-m-i-game.com.cn',
    'keywords'    => ['爱游戏', '游戏资讯', '玩家社区'],
    'description' => '爱游戏是一家专注于游戏内容与玩家互动的垂直平台，提供最新游戏动态与深度评测。',
]);

// 额外添加一个元数据
$siteMeta->setMeta('author', '爱游戏团队');

// 输出生成的描述文本
echo $siteMeta->generateDescription() . PHP_EOL;

// 输出HTML元标签（仅供示例，实际可放入页面头部）
$siteMeta->renderMetaTags();

// 如果需要，可以获取全部数据进行其他处理
// $all = $siteMeta->getAll();
// print_r($all);