<?php

/**
 * @file
 * Contains \Drupal\comment\Tests\Views\WizardTest.
 */

namespace Drupal\comment\Tests\Views;

use Drupal\views\Views;
use Drupal\views\Tests\Wizard\WizardTestBase;

/**
 * Tests the comment module integration into the wizard.
 *
 * @group comment
 * @see \Drupal\comment\Plugin\views\wizard\Comment
 */
class WizardTest extends WizardTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('node', 'comment');


  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->drupalCreateContentType(array('type' => 'page', 'name' => t('Basic page')));
    // Add comment field to page node type.
    $this->container->get('comment.manager')->addDefaultField('node', 'page');
  }

  /**
   * Tests adding a view of comments.
   */
  public function testCommentWizard() {
    $view = array();
    $view['label'] = $this->randomMachineName(16);
    $view['id'] = strtolower($this->randomMachineName(16));
    $view['show[wizard_key]'] = 'comment';
    $view['page[create]'] = TRUE;
    $view['page[path]'] = $this->randomMachineName(16);

    // Just triggering the saving should automatically choose a proper row
    // plugin.
    $this->drupalPostForm('admin/structure/views/add', $view, t('Save and edit'));
    $this->assertUrl('admin/structure/views/view/' . $view['id'], array(), 'Make sure the view saving was successful and the browser got redirected to the edit page.');

    // If we update the type first we should get a selection of comment valid
    // row plugins as the select field.

    $this->drupalGet('admin/structure/views/add');
    $this->drupalPostForm('admin/structure/views/add', $view, t('Update "of type" choice'));

    // Check for available options of the row plugin.
    $xpath = $this->constructFieldXpath('name', 'page[style][row_plugin]');
    $fields = $this->xpath($xpath);
    $options = array();
    foreach ($fields as $field) {
      $items = $this->getAllOptions($field);
      foreach ($items as $item) {
        $options[] = $item->attributes()->value;
      }
    }
    $expected_options = array('comment', 'fields');
    $this->assertEqual($options, $expected_options);

    $view['id'] = strtolower($this->randomMachineName(16));
    $this->drupalPostForm(NULL, $view, t('Save and edit'));
    $this->assertUrl('admin/structure/views/view/' . $view['id'], array(), 'Make sure the view saving was successful and the browser got redirected to the edit page.');

    $view = Views::getView($view['id']);
    $view->initHandlers();
    $row = $view->display_handler->getOption('row');
    $this->assertEqual($row['type'], 'entity:comment');

    // Check for the default filters.
    $this->assertEqual($view->filter['status']->table, 'comment_field_data');
    $this->assertEqual($view->filter['status']->field, 'status');
    $this->assertTrue($view->filter['status']->value);
    $this->assertEqual($view->filter['status_node']->table, 'node_field_data');
    $this->assertEqual($view->filter['status_node']->field, 'status');
    $this->assertTrue($view->filter['status_node']->value);

    // Check for the default fields.
    $this->assertEqual($view->field['subject']->table, 'comment_field_data');
    $this->assertEqual($view->field['subject']->field, 'subject');
  }

}
