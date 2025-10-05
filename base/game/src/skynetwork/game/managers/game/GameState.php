<?php

namespace skynetwork\game\managers\game;

enum GameState {

    case LOADING;
    case WAITING;
    case STARTING;
    case RUNNING;
    case STOPPING;

}