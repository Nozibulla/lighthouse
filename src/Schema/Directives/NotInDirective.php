<?php

namespace Nuwave\Lighthouse\Schema\Directives;

use Nuwave\Lighthouse\Support\Contracts\ArgBuilderDirective;

class NotInDirective extends BaseDirective implements ArgBuilderDirective
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
"""
Use the client given value to add a NOT IN conditional to a database query.
"""
directive @notIn(
  """
  Specify the database column to compare.
  Only required if database column has a different name than the attribute in your schema.
  """
  key: String
) repeatable on ARGUMENT_DEFINITION | INPUT_FIELD_DEFINITION
GRAPHQL;
    }

    /**
     * Apply a simple "WHERE NOT IN $values" clause.
     *
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function handleBuilder($builder, $values): object
    {
        return $builder->whereNotIn(
            $this->directiveArgValue('key', $this->nodeName()),
            $values
        );
    }
}
