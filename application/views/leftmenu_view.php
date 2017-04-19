<?php
if ($leftmenu) :
    foreach ($leftmenu['detail'] as $lcontent) :
        ?>

        <li class="active"><a href="
            <?php
            if ($lcontent->cmenu == '') :
                echo base_url() . $lcontent->menu_link;
            else:
                echo '#';
            endif;
            ?>" data-target=".legal-menu<?php echo $lcontent->id; ?>" class="nav-header collapsed" data-toggle="collapse"><i class="fa fa-fw fa-dashboard"></i> 
                <?php echo $lcontent->menu_name; ?>
                              <?php if ($lcontent->cmenu != '') : ?>
                                <i class="fa fa-collapse"></i>
                    <?php endif; ?>
            </a>
        </li>  
        <input type="hidden" value="<?php echo $lcontent->id; ?>" 
               id="<?php if($lcontent->id ==3 ){echo 'mastermenu';}
               else if($lcontent->id ==27){echo 'transactionmenu';}
               else if($lcontent->id ==31){ echo 'reportmenu';}
               else if($lcontent->id ==42){ echo 'mismenu';}
               else if($lcontent->id ==65){echo 'advancepayment';}
                else if($lcontent->id ==76){echo 'Utilitymenu';}
               else{echo '';} ?>"/> 


        <?php if ($lcontent->cmenu != '') : ?>
            <?php
            $childid = explode(',', $lcontent->cid);
            $childmenu = explode(',', $lcontent->cmenu);
            $childlink = explode(',', $lcontent->clink);
            $childcode = explode(',', $lcontent->ccode);
            $childisparent = explode(',', $lcontent->cisparent);

            $i = 0;
            foreach ($childmenu as $lchildmenu) :

                if (count($childlink) > 0) :

                    $chref = $childlink[$i];
                    $ccode = $childcode[$i];
                    $cisparent = $childisparent[$i];
                    $cid = $childid[$i];

                else:
                    $chref = '#';
                endif;
                ?>

                <?php if (($cisparent) != "SC"):
                    ?>
                    <li>
                        <ul class="legal-menu<?php echo $lcontent->id; ?> nav nav-list collapse">
                            <li class="<?php echo $ccode; ?>" >
                                <a href="<?php echo base_url() . $chref; ?>">
                                    <span class="fa fa-caret-right"></span><?php echo $lchildmenu; ?></a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- <li>
                       <ul class="legal-menu<?php echo $lcontent->id; ?>">
                                           <li><a data-toggle="collapse" class="nav-header collapsed" data-target=".scmenu<?php echo $lcontent->id; ?>" href="#"><i id="<?php echo $cid; ?>" class="fa fa-caret-right"></i><?php echo $lchildmenu; ?>              					</a></li>	
                       </ul>
                     </li>-->

                    <li> 
                        <ul class="legal-menu<?php echo $lcontent->id; ?> nav nav-list collapse"><a data-toggle="collapse" class="nav-header" data-target=".scmenu<?php echo $lcontent->id; ?>" href="
                                                                                                    #"><i class="fa fa-caret-right"></i><?php echo $lchildmenu; ?></a>
                        </ul></li>
                    <?php
                    foreach ($leftmenu['subchild_' . $cid] as $lsubchildmenu) :
                        ?>
                        <!--  /* subchild menu*/-->
                        <li>
                            <ul class="scmenu<?php echo $lcontent->id; ?> nav nav-list collapse">
                                <li class="<?php echo $lsubchildmenu->sccode; ?>" >
                                    <a href="<?php echo base_url() . $lsubchildmenu->sclink; ?>">
                                        <span>&nbsp;<i class="fa fa-fw fa-briefcase"></i><?php echo $lsubchildmenu->scmenu ?></span></a></li>
                            </ul>
                        </li>

                        <?php
                    endforeach;
                endif;
                ?>
                <?php
                $i++;
            endforeach;
        endif;
        ?>   
        <?php
    endforeach;
else:
    ?>
    <tr><td colspan="4">No records found</td></tr>
<?php
endif;
?><li>

