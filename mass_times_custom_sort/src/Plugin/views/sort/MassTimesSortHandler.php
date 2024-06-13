<?php


namespace Drupal\mass_times_custom_sort\Plugin\views\sort;

use Drupal\views\Plugin\views\sort\SortPluginBase;

/**
 * Provides a custom sort handler for the day of the week.
 *
 * @ViewsSort("mass_times")
 */
class MassTimesSortHandler extends SortPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $this->ensureMyTable();

    // Get the table alias and field name.
    $table_alias = $this->tableAlias;
    $field = $this->realField;

    // Define the order of days of the week.
    $order = [
      'sun' => 1,
      'mon' => 2,
      'tue' => 3,
      'wed' => 4,
      'thur' => 5,
      'fri' => 6,
      'sat' => 7,
    ];

    $case_statements = [];
    foreach ($order as $day => $weight) {
      $case_statements[] = "WHEN {$table_alias}.{$field} = '{$day}' THEN {$weight}";
    }

    $order_by_expression = "CASE " . implode(" ", $case_statements) . " END";

    // Add the order by clause to the query.
    $this->query->addOrderBy(NULL, $order_by_expression, $this->options['order']);
  }

}

