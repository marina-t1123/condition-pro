import { Link, useForm } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';
import {
    Box,
    ChakraProvider,
    defaultSystem,
    Input,
    Stack,
    Text,
    Textarea,
    Button,
    HStack,
    RadioGroup,
    CloseButton,
    Dialog,
    Portal
} from '@chakra-ui/react';


const Show = (props) => {

    // propsから、チーム・種目・ポジションを取得
    const { athlete, sexes } = props;

    const{ delete:destroy } = useForm();

    // 性別の登録情報を取得して、radioの値に設定
    const items = sexes.map(sex => ({
        label: sex.sex_name,
        value: String(sex.id), // Stringにしないとoptionタグで値が反映されない
    }));

    // 性別ID
    const sexId = String(athlete.sex.id);

    // 削除ボタンクリック時の処理
    const handleDelete = (athlete_id, e) => {
        //再レンダリング防止
        e.preventDefault();
        console.log('削除アクションの実行');

        destroy(route('athlete.destroy', athlete_id));
    }


    return (
        <ChakraProvider value={defaultSystem}>

            <CustomHeader />

            {/* メイン */}
            <Box className='main' width='80%' m='auto' bg='white' marginTop='20px' p='6' boxShadow='md'>
                <Box textAlign='center' mb='6'>
                    <Text fontSize='25px' mb='2'>選手詳細</Text>
                </Box>

                <Box>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>チーム</Text>
                        <Input
                            type='text'
                            id='team_name'
                            name='team_name'
                            defaultValue={athlete.team.team_name}
                            readOnly={true}
                        />
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>種目</Text>
                        <Input
                            type='text'
                            id='m_event_name'
                            name='event_name'
                            defaultValue={athlete.team.m_event.event_name}
                            readOnly={true}
                        />
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>ポジション・階級</Text>
                        <Input
                            type='text'
                            id='m_event_name'
                            name='event_name'
                            defaultValue={athlete.event_position_name}
                            readOnly={true}
                        />
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>選手名</Text>
                        <Input
                            placeholder='必須入力です'
                            type='text'
                            id='athlete_name'
                            name='athlete_name'
                            value={athlete.name}
                            readOnly={true}
                        />
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>性別</Text>
                        <RadioGroup.Root value={sexId} name='sex_id' readOnly={true}>
                            <HStack gap="6">
                                {items.map((item) => (
                                    <RadioGroup.Item key={item.value} value={item.value}>
                                        <RadioGroup.ItemHiddenInput />
                                        <RadioGroup.ItemIndicator />
                                        <RadioGroup.ItemText>{item.label}</RadioGroup.ItemText>
                                    </RadioGroup.Item>
                                ))}
                            </HStack>
                        </RadioGroup.Root>
                    </Stack>
                    <Stack gap='2' w='full' marginBottom='1rem'>
                        <Text>生年月日</Text>
                        <Input
                            placeholder='必須入力です'
                            type='date'
                            id='birthday'
                            name='birthday'
                            value={athlete.birthday}
                            readOnly={true}
                        />
                    </Stack>
                    <Stack gap="4" w="full" marginTop='1rem'>
                        <Text>メモ・備考</Text>
                        <Textarea
                            size="xl"
                            type="text"
                            id='memo'
                            name="memo"
                            value={athlete.memo}
                            readOnly={true}
                        />
                    </Stack>
                    <HStack display='flex' justifyContent='center' gap='4' p='0.5rem' m='6'>
                        <Button as={Link} href={`/athletes`} color='white' bg='gray.500' size='lg' p='5' width='30%'>選手一覧</Button>
                        <Button as={Link} href={`/athletes/team/${athlete.team.id}`} color='white' bg='orange.500' size='lg' p='5'>【{athlete.team.team_name}】選手一覧</Button>
                        <Dialog.Root>
                            <Dialog.Trigger asChild>
                                <Button variant="outline" size="md" color='white' bg='black' p='1rem'>
                                    削除
                                </Button>
                            </Dialog.Trigger>
                            <Portal>
                                <Dialog.Backdrop />
                                <Dialog.Positioner>
                                    <Dialog.Content>
                                        <Dialog.CloseTrigger asChild position="absolute" top="4" right="4">
                                            <CloseButton size="md" position="absolute" top="4" right="4" />
                                        </Dialog.CloseTrigger>
                                        <Dialog.Header>
                                            <Dialog.Title>削除前の最終確認</Dialog.Title>
                                        </Dialog.Header>
                                        <Dialog.Body>
                                            <p>
                                                この選手情報を削除しますか。
                                            </p>
                                        </Dialog.Body>
                                        <Dialog.Footer>
                                            <Dialog.ActionTrigger asChild>
                                                <Button variant="outline">キャンセル</Button>
                                            </Dialog.ActionTrigger>
                                            <Button type='submit' color='white' bg='black' p='0.5rem' onClick={(e) => handleDelete(athlete, e)}>削除する</Button>
                                        </Dialog.Footer>
                                    </Dialog.Content>
                                </Dialog.Positioner>
                            </Portal>
                        </Dialog.Root>
                    </HStack>
                </Box>
            </Box>
        </ChakraProvider>
    )
}

export default Show;