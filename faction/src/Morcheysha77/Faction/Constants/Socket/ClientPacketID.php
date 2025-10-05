<?php


namespace Morcheysha77\Faction\Constants\Socket;


interface ClientPacketID
{

    public const
        REQUEST_BROADCAST_MESSAGE_NETWORK = 0x0,
        REQUEST_BROADCAST_POPUP_NETWORK = 0x1,
        REQUEST_BROADCAST_TIP_NETWORK = 0x2,
        REQUEST_BROADCAST_TITLE_NETWORK = 0x3,
        REQUEST_BAN_NETWORK = 0x4;

}