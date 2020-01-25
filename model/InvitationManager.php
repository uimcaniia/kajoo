<?php
namespace Model;

class InvitationManager extends Bdd
{

    // CONSTANTES
    const TAB_INVIT = 'invitation';

    // nom de la table

    // ******************************************************************************************************************
    // ajoute une invitation
    public function add(Invitation $invitation)
    {
        $param3 = $invitation->getId_send();
        $param4 = $invitation->getId_receive();

        $request = 'INSERT INTO ' . self::TAB_INVIT . '(id_send, id_receive) VALUES (:id_send, :id_receive)';
        $arr = array(
            array(
                ":id_send",
                $param3
            ),
            array(
                ":id_receive",
                $param4
            )
        );
        parent::reqPrepaExec($request, $arr);

        $request2 = 'SELECT * FROM ' . self::TAB_INVIT . ' WHERE id_send = :id_send AND id_receive = :id_receive';
        $arr2 = array(
            array(
                ":id_send",
                $param3
            ),
            array(
                ":id_receive",
                $param4
            )
        );
        $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
        return $aRes2;
    }

    // *****************************************************************************************************************
    // retourne l'invitation entre 2 personne
    public function getInvitation($id_send, $id_receive)
    {
        $request = 'SELECT * FROM ' . self::TAB_INVIT . ' WHERE id_send = :id_send AND id_receive = :id_receive';
        $arr = array(
            array(
                ":id_send",
                $id_send
            ),
            array(
                ":id_receive",
                $id_receive
            )
        );
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // *****************************************************************************************************************
    // retourne toute les invitation d'un user
    public function getInvitationOfUser($id_send)
    {
        $request = 'SELECT * FROM ' . self::TAB_INVIT . ' WHERE id_send = :id_send';
        $arr = array(
            array(
                ":id_send",
                $id_send
            )
        );
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // *****************************************************************************************************************
    // retourne toute les invitation reçut
    public function getInvitationOfAllFriend($id_receive)
    {
        $request = 'SELECT * FROM ' . self::TAB_INVIT . ' WHERE id_receive = :id_receive';
        $arr = array(
            array(
                ":id_receive",
                $id_receive
            )
        );
        $aRes = parent::reqPrepaExecSEl($request, $arr);
        return $aRes;
    }

    // ******************************************************************************************************************
    // supprime une invitation entre un user et un friend
    public function delete($id_send, $id_receive)
    {
        $request = 'DELETE FROM ' . self::TAB_INVIT . ' WHERE id_receive = :id_receive AND id_send = :id_send';
        $arr = array(
            array(
                ":id_send",
                $id_send
            ),
            array(
                ":id_receive",
                $id_receive
            )
        );
        $aRes = parent::reqPrepaExec($request, $arr);

        $request2 = 'SELECT * FROM ' . self::TAB_INVIT . ' WHERE id_receive = :id_receive AND id_send = :id_send';
        $arr2 = array(
            array(
                ":id_send",
                $id_send
            ),
            array(
                ":id_receive",
                $id_receive
            )
        );
        $aRes2 = parent::reqPrepaExecSEl($request2, $arr2);
        return $aRes2;
    }
}