<?php
namespace Monad\State;

use Monad as M;

const get = 'Monad\State\get';

/**
 * get :: State s m => m s
 *
 * Return the state from the internals of the monad.
 *
 * @return M\State
 */
function get()
{
    return state(function ($state) {
        return [$state, $state];
    });
}

const put = 'Monad\State\put';

/**
 * put :: State s m => s -> m ()
 *
 * Replace the state inside the monad.
 *
 * @param mixed $state
 * @return M\State
 */
function put($state)
{
    return state(function () use ($state) {
        return [null, $state];
    });
}

const state = 'Monad\State\state';

/**
 * state :: State s m => (s -> (a, s)) -> m a
 *
 * Embed a simple state action into the monad.
 *
 * @param callable $stateFunction
 * @return M\State
 */
function state(callable $stateFunction)
{
    return M\State::of(function ($state) use ($stateFunction) {
        return call_user_func($stateFunction, $state);
    });
}

const gets = 'Monad\State\gets';

/**
 * gets :: State s m => (s -> a) -> m a
 *
 * Gets specific component of the state, using a projection function supplied.
 *
 * @param callable $transformation
 * @return M\State
 */
function gets(callable $transformation)
{
    return M\State::of(function ($state) use ($transformation) {
        return [call_user_func($transformation, $state), $state];
    });
}

const value = 'Monad\State\value';

/**
 * state :: State s m => a -> m a
 *
 * Put value inside ot the monad
 *
 * @param mixed $value
 * @return M\State
 */
function value($value)
{
    return M\State::of(function ($state) use ($value) {
        return [$value, $state];
    });
}

const modify = 'Monad\State\modify';

/**
 * modify :: State s m => (s -> s) -> m ()
 *
 * Monadic state transformer.
 *
 * Maps an old state to a new state inside a state monad.
 * The old state is thrown away.
 *
 * @param callable $transformation
 * @return M\State
 */
function modify(callable $transformation)
{
    return M\State::of(function ($state) use ($transformation) {
        return [null, $transformation($state)];
    });
}
